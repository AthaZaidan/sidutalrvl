<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Ak1;
use App\Models\City;
use App\Models\Company;
use App\Models\EducationLevel;
use App\Models\JobField;
use App\Models\JobVacancy;
use App\Models\JobVacancyApplicant;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index(Request $request)
    {
        $query = JobVacancy::with(['company.badanUsaha', 'city', 'jobField', 'educationLevel'])
            ->where('deleted_vacancy', '0')
            ->where('publish_status', SidutaConstants::PUBLISHED);

        if ($request->filled('job_filter')) {
            $kw = trim((string) $request->query('job_filter'));
            $query->where('title_jobvacancy', 'like', "%{$kw}%");
        }
        if ($request->filled('category_field') && $request->query('category_field') !== 'all') {
            $query->where('jobfield_vacancy', (int) $request->query('category_field'));
        }
        if ($request->filled('company') && $request->query('company') !== 'all') {
            $query->where('company_id', (int) $request->query('company'));
        }
        if ($request->filled('city')) {
            $query->where('city_vacancy', (int) $request->query('city'));
        }
        if ($request->filled('education_level')) {
            $query->where('education_level', (int) $request->query('education_level'));
        }
        if ($request->boolean('disability')) {
            $query->where('disability_status', 1);
        }

        $jobvacancies = $query->orderByDesc('id_jobvacancy')->paginate(10)->withQueryString();
        $categories = JobField::where('deleted_jobfield', '0')->orderBy('name_jobfield')->get();
        $companies = Company::where('deleted_company', '0')->orderBy('name_company')->get();
        $cities = City::orderBy('city_name')->get();
        $educationLevels = EducationLevel::where('deleted_educationlevel', '0')->get();

        return view('public.job-vacancies.index', compact(
            'jobvacancies', 'categories', 'companies', 'cities', 'educationLevels'
        ));
    }

    public function detail(int $id)
    {
        $jobvacancy = JobVacancy::with(['company.badanUsaha', 'city', 'jobField', 'subJobField', 'educationLevel', 'skills', 'disabilities'])
            ->where('deleted_vacancy', '0')
            ->where('id_jobvacancy', $id)
            ->firstOrFail();

        $similarJobs = JobVacancy::with(['company.badanUsaha', 'city'])
            ->where('deleted_vacancy', '0')
            ->where('publish_status', SidutaConstants::PUBLISHED)
            ->where('id_jobvacancy', '!=', $id)
            ->orderByDesc('id_jobvacancy')
            ->limit(4)
            ->get();

        $user = Auth::guard('web')->user();
        $hasApplied = false;
        $hasAk1 = false;

        if ($user && (int) $user->role_id === SidutaConstants::ANGKATAN_KERJA) {
            $hasApplied = JobVacancyApplicant::where('jobvacancy_id', $id)->where('user_id', $user->id)->exists();
            $hasAk1 = Ak1::where('user_id', $user->id)
                ->where('deleted_ak1', 0)
                ->where('process_status', '>', 0)
                ->where('process_status', '<', 4)
                ->exists();
        }

        return view('public.job-vacancies.show', compact('jobvacancy', 'similarJobs', 'hasApplied', 'hasAk1'));
    }

    public function apply(int $id)
    {
        $user = Auth::guard('web')->user();
        if (!$user || (int) $user->role_id !== SidutaConstants::ANGKATAN_KERJA) {
            return redirect()->route('jobseeker.login')->with('notyf_error', 'Silakan masuk sebagai Pencari Kerja terlebih dahulu.');
        }

        $jobvacancy = JobVacancy::where('id_jobvacancy', $id)->where('deleted_vacancy', '0')->firstOrFail();

        $hasAk1 = Ak1::where('user_id', $user->id)
            ->where('deleted_ak1', 0)
            ->where('process_status', '>', 0)
            ->where('process_status', '<', 4)
            ->exists();

        if (!$hasAk1) {
            return redirect()->route('main.job_vacancy.detail', $id)
                ->with('notyf_error', 'Silakan melakukan registrasi Kartu AK-1 terlebih dahulu.');
        }

        $exists = JobVacancyApplicant::where('jobvacancy_id', $id)->where('user_id', $user->id)->exists();
        if ($exists) {
            return redirect()->route('main.job_vacancy.detail', $id)->with('notyf_error', 'Anda sudah melamar lowongan ini.');
        }

        JobVacancyApplicant::create([
            'jobvacancy_id' => $id,
            'user_id' => $user->id,
            'process_apply' => SidutaConstants::APPLY_PENDING,
        ]);

        $this->notifier->notifyClient(
            $user->full_name . ' melamar sebagai ' . $jobvacancy->title_jobvacancy . ' di perusahaan Anda.',
            null,
            $jobvacancy->company_id,
            null,
            $id
        );
        $this->notifier->notifyClient(
            'Lamaran kerja ' . $jobvacancy->title_jobvacancy . ' telah terkirim.',
            $user->id,
            null,
            null,
            $id
        );

        return redirect()->route('main.job_vacancy.detail', $id)->with('notyf_success', 'Berhasil mengirim lamaran.');
    }
}
