<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Disability;
use App\Models\EducationLevel;
use App\Models\JobField;
use App\Models\School;
use App\Models\Skill;
use App\Models\SubJobField;
use App\Models\University;
use App\Models\User;
use App\Services\NotificationService;
use App\Support\RecaptchaVerifier;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JobseekerAuthController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function showLogin()
    {
        if (Auth::guard('web')->check() && (int) Auth::guard('web')->user()->role_id === SidutaConstants::ANGKATAN_KERJA) {
            return redirect()->route('jobseeker.dashboard');
        }

        return view('auth.jobseeker.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'inputEmail' => ['required', 'email'],
            'inputPassword' => ['required', 'string'],
        ], [
            'inputEmail.required' => 'Mohon isi email Anda.',
            'inputPassword.required' => 'Mohon isi password Anda.',
        ]);

        if (!RecaptchaVerifier::verify($request)) {
            return back()->withInput()->with('notyf_error', 'Verifikasi reCAPTCHA gagal.');
        }

        $user = User::where('email', $data['inputEmail'])
            ->where('role_id', SidutaConstants::ANGKATAN_KERJA)
            ->where('deleted_user', '0')
            ->first();

        if (!$user || !Hash::check($data['inputPassword'], $user->password)) {
            return back()->withInput()->with('notyf_error', 'Email atau password salah.');
        }

        if ((int) $user->is_active !== 1) {
            return back()->withInput()->with('notyf_error', 'Akun belum aktif.');
        }

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return match ((int) $user->reg_status) {
            SidutaConstants::STATUS_REG_DATADIRI => redirect()->route('jobseeker.register.step2')->with('notyf_success', 'Anda berhasil masuk, silakan lengkapi data diri.'),
            SidutaConstants::STATUS_REG_SPESIALISASI => redirect()->route('jobseeker.register.step3')->with('notyf_success', 'Silakan lengkapi spesialisasi.'),
            SidutaConstants::STATUS_REG_PENDIDIKAN => redirect()->route('jobseeker.register.step4')->with('notyf_success', 'Silakan lengkapi data pendidikan.'),
            default => redirect()->route('jobseeker.dashboard')->with('notyf_success', 'Anda berhasil masuk.'),
        };
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('notyf_success', 'Anda berhasil keluar.');
    }

    public function showRegisterStep1()
    {
        return view('auth.jobseeker.register-step1');
    }

    public function submitRegisterStep1(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:128'],
            'last_name' => ['nullable', 'string', 'max:128'],
            'email' => ['required', 'email', 'max:128', 'unique:user,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? '',
            'email' => $data['email'],
            'image' => 'default.jpg',
            'password' => Hash::make($data['password']),
            'role_id' => SidutaConstants::ANGKATAN_KERJA,
            'reg_status' => SidutaConstants::STATUS_REG_DATADIRI,
            'is_active' => 1,
            'date_create' => time(),
            'deleted_user' => '0',
        ]);

        $this->notifier->notifyAdmin('Angkatan kerja baru mendaftar: ' . $user->full_name, 4, ['user_id' => $user->id]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->route('jobseeker.register.step2')->with('notyf_success', 'Akun berhasil dibuat, silakan lengkapi data diri.');
    }

    public function showRegisterStep2()
    {
        $user = Auth::guard('web')->user();
        $disabilities = Disability::where('deleted_disability', '0')->get();
        return view('auth.jobseeker.register-step2', compact('user', 'disabilities'));
    }

    public function submitRegisterStep2(Request $request)
    {
        $user = Auth::guard('web')->user();
        $data = $request->validate([
            'nik' => ['required', 'string', 'max:16'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'place_birth' => ['required', 'string', 'max:256'],
            'dob' => ['required', 'date'],
            'no_handphone' => ['required', 'string', 'max:32'],
            'religion' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:128'],
            'address' => ['required', 'string'],
            'disabilities' => ['nullable', 'array'],
        ]);

        $user->update([
            'nik' => $data['nik'],
            'gender' => $data['gender'],
            'place_birth' => $data['place_birth'],
            'dob' => $data['dob'],
            'no_handphone' => $data['no_handphone'],
            'religion' => $data['religion'],
            'status' => $data['status'],
            'district' => $data['district'],
            'address' => $data['address'],
            'reg_status' => SidutaConstants::STATUS_REG_SPESIALISASI,
        ]);

        DB::table('user_list_disability')->where('user_id', $user->id)->delete();
        foreach ($data['disabilities'] ?? [] as $disId) {
            DB::table('user_list_disability')->insert([
                'user_id' => $user->id,
                'user_disability' => (int) $disId,
            ]);
        }

        return redirect()->route('jobseeker.register.step3')->with('notyf_success', 'Data diri disimpan.');
    }

    public function showRegisterStep3()
    {
        $user = Auth::guard('web')->user();
        $jobFields = JobField::where('deleted_jobfield', '0')->orderBy('name_jobfield')->get();
        $subJobFields = SubJobField::where('deleted_subjobfield', '0')->orderBy('name_subjobfield')->get();
        $skills = Skill::where('deleted_skill', '0')->orderBy('name_skill')->get();
        return view('auth.jobseeker.register-step3', compact('user', 'jobFields', 'subJobFields', 'skills'));
    }

    public function submitRegisterStep3(Request $request)
    {
        $user = Auth::guard('web')->user();
        $data = $request->validate([
            'job_field' => ['required', 'integer'],
            'sub_job_field' => ['required', 'integer'],
            'skills' => ['nullable', 'array'],
        ]);

        $user->update([
            'job_field' => $data['job_field'],
            'sub_job_field' => $data['sub_job_field'],
            'reg_status' => SidutaConstants::STATUS_REG_PENDIDIKAN,
        ]);

        DB::table('user_listskill')->where('user_id', $user->id)->delete();
        foreach ($data['skills'] ?? [] as $skillId) {
            DB::table('user_listskill')->insert([
                'user_id' => $user->id,
                'skill_id' => (int) $skillId,
            ]);
        }

        return redirect()->route('jobseeker.register.step4')->with('notyf_success', 'Data spesialisasi disimpan.');
    }

    public function showRegisterStep4()
    {
        $user = Auth::guard('web')->user();
        $educationLevels = EducationLevel::where('deleted_educationlevel', '0')->get();
        $schools = School::where('deleted_school', '0')->get();
        $universities = University::where('deleted_university', '0')->get();
        return view('auth.jobseeker.register-step4', compact('user', 'educationLevels', 'schools', 'universities'));
    }

    public function submitRegisterStep4(Request $request)
    {
        $user = Auth::guard('web')->user();
        $data = $request->validate([
            'education_level' => ['required', 'integer'],
            'educational_institutions' => ['required', 'integer'],
            'major' => ['required', 'string', 'max:64'],
            'start_period' => ['nullable', 'date'],
            'end_period' => ['required', 'string', 'max:4'],
            'ipk' => ['nullable', 'numeric', 'min:0', 'max:4'],
        ]);

        $user->update([
            'education_level' => $data['education_level'],
            'educational_institutions' => $data['educational_institutions'],
            'major' => $data['major'],
            'start_period' => $data['start_period'] ?? null,
            'end_period' => $data['end_period'],
            'ipk' => $data['ipk'] ?? null,
            'reg_status' => SidutaConstants::STATUS_REG_JSDONE,
        ]);

        return redirect()->route('jobseeker.register.done');
    }

    public function showRegisterDone()
    {
        return view('auth.jobseeker.register-done');
    }
}
