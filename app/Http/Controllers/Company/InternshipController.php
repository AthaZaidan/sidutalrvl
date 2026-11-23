<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\EducationLevel;
use App\Models\Internship;
use App\Models\InternshipApplicant;
use App\Models\JobField;
use App\Models\SubJobField;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index()
    {
        $company = Auth::guard('company')->user();
        $internships = Internship::with('city')
            ->withCount('applicants')
            ->where('company_id', $company->id_company)
            ->where('deleted_intern', '0')
            ->orderByDesc('id_intern')
            ->paginate(10);

        return view('company.internships.index', compact('company', 'internships'));
    }

    public function create()
    {
        return view('company.internships.form', [
            'internship' => null,
            'jobFields' => JobField::where('deleted_jobfield', '0')->get(),
            'subJobFields' => SubJobField::where('deleted_subjobfield', '0')->get(),
            'cities' => City::orderBy('city_name')->get(),
            'educationLevels' => EducationLevel::where('deleted_educationlevel', '0')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $company = Auth::guard('company')->user();
        $data = $request->validate([
            'title_intern' => ['required', 'string', 'max:256'],
            'jobfield_intern' => ['required', 'string'],
            'subjobfield_intern' => ['required', 'integer'],
            'city_intern' => ['required', 'integer'],
            'length_intern' => ['required', 'integer', 'min:1', 'max:24'],
            'min_edu_level' => ['required', 'integer'],
            'salary_start' => ['nullable', 'string', 'max:256'],
            'salary_end' => ['nullable', 'string', 'max:256'],
            'deadline_intern' => ['nullable', 'date'],
            'desc_intern' => ['required', 'string'],
        ]);

        $intern = Internship::create([
            'title_intern' => $data['title_intern'],
            'jobfield_intern' => $data['jobfield_intern'],
            'subjobfield_intern' => $data['subjobfield_intern'],
            'city_intern' => $data['city_intern'],
            'length_intern' => $data['length_intern'],
            'duration_intern' => $data['length_intern'],
            'min_edu_level' => $data['min_edu_level'],
            'salary_start' => $data['salary_start'] ?? '0',
            'salary_end' => $data['salary_end'] ?? '0',
            'deadline_intern' => $data['deadline_intern'] ?? null,
            'desc_intern' => $data['desc_intern'],
            'experience_intern' => 0,
            'publish_status' => SidutaConstants::SUBMITTED,
            'process_status' => SidutaConstants::PROC_SUBMITTED,
            'company_id' => $company->id_company,
            'ip_id' => 0,
            'deleted_intern' => '0',
        ]);

        $this->notifier->notifyAdmin(
            'Pengajuan Pemagangan baru dari ' . $company->display_name . ': ' . $intern->title_intern,
            10,
            ['company_id' => $company->id_company, 'in_id' => $intern->id_intern]
        );

        return redirect()->route('company.internship.index')->with('notyf_success', 'Program magang diajukan untuk verifikasi.');
    }

    public function applicants(int $id)
    {
        $company = Auth::guard('company')->user();
        $internship = Internship::where('id_intern', $id)->where('company_id', $company->id_company)->firstOrFail();
        $applicants = InternshipApplicant::with('user.educationLevel')->where('intern_id', $id)->get();

        return view('company.internships.applicants', compact('internship', 'applicants'));
    }

    public function updateApplicantStatus(Request $request, int $applicantId)
    {
        $company = Auth::guard('company')->user();
        $app = InternshipApplicant::with('internship')->where('id_listapplicant', $applicantId)->firstOrFail();
        abort_unless((int) $app->internship->company_id === (int) $company->id_company, 403);

        $data = $request->validate(['process_apply' => ['required', 'in:0,1,2,3']]);
        $app->update(['process_apply' => (int) $data['process_apply']]);

        return back()->with('notyf_success', 'Status pelamar magang diperbarui.');
    }
}
