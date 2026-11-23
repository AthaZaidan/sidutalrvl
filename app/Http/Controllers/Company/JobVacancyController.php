<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\ApplicantCall;
use App\Models\City;
use App\Models\Disability;
use App\Models\EducationLevel;
use App\Models\JobField;
use App\Models\JobVacancy;
use App\Models\JobVacancyApplicant;
use App\Models\Skill;
use App\Models\SubJobField;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobVacancyController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index()
    {
        $company = Auth::guard('company')->user();
        $vacancies = JobVacancy::with(['jobField', 'city'])
            ->withCount('applicants')
            ->where('company_id', $company->id_company)
            ->where('deleted_vacancy', '0')
            ->orderByDesc('id_jobvacancy')
            ->paginate(10);

        return view('company.job-vacancies.index', compact('company', 'vacancies'));
    }

    public function create()
    {
        $jobFields = JobField::where('deleted_jobfield', '0')->orderBy('name_jobfield')->get();
        $subJobFields = SubJobField::where('deleted_subjobfield', '0')->orderBy('name_subjobfield')->get();
        $cities = City::orderBy('city_name')->get();
        $educationLevels = EducationLevel::where('deleted_educationlevel', '0')->get();
        $skills = Skill::where('deleted_skill', '0')->orderBy('name_skill')->get();
        $disabilities = Disability::where('deleted_disability', '0')->get();

        return view('company.job-vacancies.form', [
            'vacancy' => null,
            'jobFields' => $jobFields,
            'subJobFields' => $subJobFields,
            'cities' => $cities,
            'educationLevels' => $educationLevels,
            'skills' => $skills,
            'disabilities' => $disabilities,
        ]);
    }

    public function store(Request $request)
    {
        $company = Auth::guard('company')->user();
        $data = $request->validate([
            'title_jobvacancy' => ['required', 'string', 'max:256'],
            'jobfield_vacancy' => ['required', 'integer'],
            'subjobfield_vacancy' => ['required', 'integer'],
            'city_vacancy' => ['required', 'integer'],
            'education_level' => ['nullable', 'integer'],
            'experience_vacancy' => ['required', 'integer', 'min:0'],
            'salary_start' => ['nullable', 'string', 'max:256'],
            'salary_end' => ['nullable', 'string', 'max:256'],
            'deadline_vacancy' => ['nullable', 'date'],
            'desc_vacancy' => ['required', 'string'],
            'disability_status' => ['nullable', 'in:0,1'],
            'skills' => ['nullable', 'array'],
            'disabilities' => ['nullable', 'array'],
        ]);

        $jv = JobVacancy::create([
            'title_jobvacancy' => $data['title_jobvacancy'],
            'jobfield_vacancy' => $data['jobfield_vacancy'],
            'subjobfield_vacancy' => $data['subjobfield_vacancy'],
            'city_vacancy' => $data['city_vacancy'],
            'education_level' => $data['education_level'] ?? null,
            'experience_vacancy' => $data['experience_vacancy'],
            'salary_start' => $data['salary_start'] ?? '0',
            'salary_end' => $data['salary_end'] ?? '0',
            'deadline_vacancy' => $data['deadline_vacancy'] ?? null,
            'desc_vacancy' => $data['desc_vacancy'],
            'disability_status' => (int) ($data['disability_status'] ?? 0),
            'type_vacancy' => 1,
            'duration_vacancy' => 12,
            'publish_status' => SidutaConstants::SUBMITTED,
            'process_status' => SidutaConstants::PROC_SUBMITTED,
            'company_id' => $company->id_company,
            'deleted_vacancy' => '0',
        ]);

        foreach ($data['skills'] ?? [] as $sid) {
            DB::table('jv_listskill')->insert(['jv_id' => $jv->id_jobvacancy, 'skill_id' => (int) $sid]);
        }
        foreach ($data['disabilities'] ?? [] as $did) {
            DB::table('job_listdisability')->insert(['job_vacancy_id' => $jv->id_jobvacancy, 'disability_id' => (int) $did]);
        }

        $this->notifier->notifyAdmin(
            'Pengajuan Lowongan Kerja baru dari ' . $company->display_name . ': ' . $jv->title_jobvacancy,
            6,
            ['company_id' => $company->id_company, 'jv_id' => $jv->id_jobvacancy]
        );

        return redirect()->route('company.job_vacancy.index')->with('notyf_success', 'Lowongan kerja diajukan untuk verifikasi.');
    }

    public function edit(int $id)
    {
        $company = Auth::guard('company')->user();
        $vacancy = JobVacancy::with(['skills', 'disabilities'])
            ->where('id_jobvacancy', $id)
            ->where('company_id', $company->id_company)
            ->firstOrFail();

        return view('company.job-vacancies.form', [
            'vacancy' => $vacancy,
            'jobFields' => JobField::where('deleted_jobfield', '0')->orderBy('name_jobfield')->get(),
            'subJobFields' => SubJobField::where('deleted_subjobfield', '0')->orderBy('name_subjobfield')->get(),
            'cities' => City::orderBy('city_name')->get(),
            'educationLevels' => EducationLevel::where('deleted_educationlevel', '0')->get(),
            'skills' => Skill::where('deleted_skill', '0')->orderBy('name_skill')->get(),
            'disabilities' => Disability::where('deleted_disability', '0')->get(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $company = Auth::guard('company')->user();
        $jv = JobVacancy::where('id_jobvacancy', $id)->where('company_id', $company->id_company)->firstOrFail();

        $data = $request->validate([
            'title_jobvacancy' => ['required', 'string', 'max:256'],
            'jobfield_vacancy' => ['required', 'integer'],
            'subjobfield_vacancy' => ['required', 'integer'],
            'city_vacancy' => ['required', 'integer'],
            'education_level' => ['nullable', 'integer'],
            'experience_vacancy' => ['required', 'integer', 'min:0'],
            'salary_start' => ['nullable', 'string', 'max:256'],
            'salary_end' => ['nullable', 'string', 'max:256'],
            'deadline_vacancy' => ['nullable', 'date'],
            'desc_vacancy' => ['required', 'string'],
            'disability_status' => ['nullable', 'in:0,1'],
            'skills' => ['nullable', 'array'],
            'disabilities' => ['nullable', 'array'],
        ]);

        $jv->update([
            'title_jobvacancy' => $data['title_jobvacancy'],
            'jobfield_vacancy' => $data['jobfield_vacancy'],
            'subjobfield_vacancy' => $data['subjobfield_vacancy'],
            'city_vacancy' => $data['city_vacancy'],
            'education_level' => $data['education_level'] ?? null,
            'experience_vacancy' => $data['experience_vacancy'],
            'salary_start' => $data['salary_start'] ?? '0',
            'salary_end' => $data['salary_end'] ?? '0',
            'deadline_vacancy' => $data['deadline_vacancy'] ?? null,
            'desc_vacancy' => $data['desc_vacancy'],
            'disability_status' => (int) ($data['disability_status'] ?? 0),
        ]);

        DB::table('jv_listskill')->where('jv_id', $jv->id_jobvacancy)->delete();
        foreach ($data['skills'] ?? [] as $sid) {
            DB::table('jv_listskill')->insert(['jv_id' => $jv->id_jobvacancy, 'skill_id' => (int) $sid]);
        }

        DB::table('job_listdisability')->where('job_vacancy_id', $jv->id_jobvacancy)->delete();
        foreach ($data['disabilities'] ?? [] as $did) {
            DB::table('job_listdisability')->insert(['job_vacancy_id' => $jv->id_jobvacancy, 'disability_id' => (int) $did]);
        }

        return redirect()->route('company.job_vacancy.index')->with('notyf_success', 'Lowongan kerja berhasil diperbarui.');
    }

    public function close(int $id)
    {
        $company = Auth::guard('company')->user();
        $jv = JobVacancy::where('id_jobvacancy', $id)->where('company_id', $company->id_company)->firstOrFail();
        $jv->update(['publish_status' => SidutaConstants::CLOSED]);
        return back()->with('notyf_success', 'Lowongan kerja ditutup.');
    }

    public function applicants(int $id)
    {
        $company = Auth::guard('company')->user();
        $vacancy = JobVacancy::where('id_jobvacancy', $id)->where('company_id', $company->id_company)->firstOrFail();
        $applicants = JobVacancyApplicant::with(['user.educationLevel', 'user.skills'])
            ->where('jobvacancy_id', $id)
            ->orderByDesc('id_listapplicant')
            ->get();

        return view('company.job-vacancies.applicants', compact('vacancy', 'applicants'));
    }

    public function updateApplicantStatus(Request $request, int $applicantId)
    {
        $company = Auth::guard('company')->user();
        $app = JobVacancyApplicant::with('jobVacancy')->where('id_listapplicant', $applicantId)->firstOrFail();
        abort_unless((int) $app->jobVacancy->company_id === (int) $company->id_company, 403);

        $data = $request->validate(['process_apply' => ['required', 'in:0,1,2,3']]);
        $app->update(['process_apply' => (int) $data['process_apply']]);

        $statusText = match ((int) $data['process_apply']) {
            2 => 'Diterima',
            3 => 'Ditolak',
            1 => 'Shortlist',
            default => 'Diproses',
        };
        $this->notifier->notifyClient(
            'Status lamaran Anda pada ' . $app->jobVacancy->title_jobvacancy . ' diperbarui menjadi: ' . $statusText,
            $app->user_id,
            null,
            null,
            $app->jobvacancy_id
        );

        return back()->with('notyf_success', 'Status pelamar diperbarui.');
    }

    public function callApplicant(Request $request, int $applicantId)
    {
        $company = Auth::guard('company')->user();
        $app = JobVacancyApplicant::with('jobVacancy')->where('id_listapplicant', $applicantId)->firstOrFail();
        abort_unless((int) $app->jobVacancy->company_id === (int) $company->id_company, 403);

        $data = $request->validate([
            'date_call' => ['required', 'date'],
            'hour_call' => ['required', 'string', 'max:25'],
            'place_call' => ['required', 'string'],
            'desc_call' => ['required', 'string'],
        ]);

        ApplicantCall::create([
            'date_call' => $data['date_call'],
            'hour_call' => $data['hour_call'],
            'place_call' => $data['place_call'],
            'desc_call' => $data['desc_call'],
            'user_id' => $app->user_id,
        ]);

        $this->notifier->notifyClient(
            'Panggilan interview dari ' . $company->display_name . ' pada ' . $data['date_call'] . ' jam ' . $data['hour_call'],
            $app->user_id,
            null,
            null,
            $app->jobvacancy_id
        );

        return back()->with('notyf_success', 'Panggilan interview terkirim ke pelamar.');
    }
}
