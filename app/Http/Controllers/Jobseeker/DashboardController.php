<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\Ak1;
use App\Models\ApplicantCall;
use App\Models\Disability;
use App\Models\EducationLevel;
use App\Models\InternshipApplicant;
use App\Models\JobField;
use App\Models\JobVacancyApplicant;
use App\Models\Skill;
use App\Models\SubJobField;
use App\Models\TrainingApplicant;
use App\Models\UserExperience;
use App\Models\UserFile;
use App\Models\UserLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        $ak1 = Ak1::where('user_id', $user->id)->where('deleted_ak1', 0)->latest('id_ak1')->first();
        $jobApps = JobVacancyApplicant::with('jobVacancy.company')->where('user_id', $user->id)->orderByDesc('id_listapplicant')->get();
        $internApps = InternshipApplicant::with('internship')->where('user_id', $user->id)->orderByDesc('id_listapplicant')->get();
        $trainApps = TrainingApplicant::with('training.lpk')->where('user_id', $user->id)->orderByDesc('id_listapplicant')->get();
        $calls = ApplicantCall::where('user_id', $user->id)->orderByDesc('id_call')->get();

        return view('jobseeker.dashboard', compact('user', 'ak1', 'jobApps', 'internApps', 'trainApps', 'calls'));
    }

    public function profile()
    {
        $user = Auth::guard('web')->user()->load(['jobField', 'subJobField', 'educationLevel', 'skills', 'disabilities', 'experiences', 'files', 'languages']);
        return view('jobseeker.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::guard('web')->user()->load(['skills', 'disabilities', 'experiences', 'files', 'languages']);
        $jobFields = JobField::where('deleted_jobfield', '0')->orderBy('name_jobfield')->get();
        $subJobFields = SubJobField::where('deleted_subjobfield', '0')->orderBy('name_subjobfield')->get();
        $educationLevels = EducationLevel::where('deleted_educationlevel', '0')->get();
        $skills = Skill::where('deleted_skill', '0')->orderBy('name_skill')->get();
        $disabilities = Disability::where('deleted_disability', '0')->get();

        return view('jobseeker.edit-profile', compact('user', 'jobFields', 'subJobFields', 'educationLevels', 'skills', 'disabilities'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:128'],
            'last_name' => ['nullable', 'string', 'max:128'],
            'no_handphone' => ['required', 'string', 'max:32'],
            'no_wa' => ['nullable', 'string', 'max:15'],
            'address' => ['required', 'string'],
            'district' => ['nullable', 'string', 'max:128'],
            'job_field' => ['nullable', 'integer'],
            'sub_job_field' => ['nullable', 'integer'],
            'education_level' => ['nullable', 'integer'],
            'major' => ['nullable', 'string', 'max:64'],
            'skills' => ['nullable', 'array'],
            'disabilities' => ['nullable', 'array'],
        ]);

        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? '',
            'no_handphone' => $data['no_handphone'],
            'no_wa' => $data['no_wa'] ?? null,
            'address' => $data['address'],
            'district' => $data['district'] ?? $user->district,
            'job_field' => $data['job_field'] ?? $user->job_field,
            'sub_job_field' => $data['sub_job_field'] ?? $user->sub_job_field,
            'education_level' => $data['education_level'] ?? $user->education_level,
            'major' => $data['major'] ?? $user->major,
        ]);

        if ($request->has('skills')) {
            DB::table('user_listskill')->where('user_id', $user->id)->delete();
            foreach ($data['skills'] ?? [] as $sid) {
                DB::table('user_listskill')->insert(['user_id' => $user->id, 'skill_id' => (int) $sid]);
            }
        }

        if ($request->has('disabilities')) {
            DB::table('user_list_disability')->where('user_id', $user->id)->delete();
            foreach ($data['disabilities'] ?? [] as $did) {
                DB::table('user_list_disability')->insert(['user_id' => $user->id, 'user_disability' => (int) $did]);
            }
        }

        return redirect()->route('jobseeker.profile')->with('notyf_success', 'Profil berhasil diperbarui.');
    }

    public function storeExperience(Request $request)
    {
        $user = Auth::guard('web')->user();
        $data = $request->validate([
            'position' => ['required', 'string', 'max:100'],
            'company' => ['required', 'string', 'max:250'],
            'time' => ['required', 'string', 'max:32'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        UserExperience::create(array_merge($data, ['user_id' => $user->id]));
        return back()->with('notyf_success', 'Pengalaman kerja ditambahkan.');
    }

    public function deleteExperience(int $id)
    {
        UserExperience::where('id', $id)->where('user_id', Auth::guard('web')->id())->delete();
        return back()->with('notyf_success', 'Pengalaman kerja dihapus.');
    }

    public function storeLanguage(Request $request)
    {
        $data = $request->validate(['language' => ['required', 'string', 'max:256']]);
        UserLanguage::create([
            'id_user' => Auth::guard('web')->id(),
            'language' => $data['language'],
            'deleted' => 0,
        ]);
        return back()->with('notyf_success', 'Bahasa ditambahkan.');
    }

    public function storeFile(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:1,2,3'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $path = $request->file('file')->store('uploads/user_files', 'public');
        UserFile::create([
            'user_id' => Auth::guard('web')->id(),
            'title' => $data['title'],
            'type' => (int) $data['type'],
            'file_url' => $path,
            'deleted' => 0,
        ]);

        return back()->with('notyf_success', 'Dokumen berhasil diunggah.');
    }
}
