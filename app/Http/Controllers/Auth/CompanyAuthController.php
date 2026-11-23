<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BadanUsaha;
use App\Models\Company;
use App\Models\CompanyCategory;
use App\Services\NotificationService;
use App\Support\RecaptchaVerifier;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyAuthController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function showLogin()
    {
        if (Auth::guard('company')->check()) {
            return redirect()->route('company.dashboard');
        }
        return view('auth.company.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'inputEmail' => ['required', 'email'],
            'inputPassword' => ['required', 'string'],
        ]);

        if (!RecaptchaVerifier::verify($request)) {
            return back()->withInput()->with('notyf_error', 'Verifikasi reCAPTCHA gagal.');
        }

        $company = Company::where('email_company', $data['inputEmail'])
            ->where('deleted_company', '0')
            ->first();

        if (!$company || !Hash::check($data['inputPassword'], $company->password_company)) {
            return back()->withInput()->with('notyf_error', 'Email atau password salah.');
        }

        if ((int) $company->is_activecompany !== 1) {
            return back()->withInput()->with('notyf_error', 'Akun perusahaan belum aktif.');
        }

        Auth::guard('company')->login($company);
        $request->session()->regenerate();

        if ((int) $company->status_regcompany === SidutaConstants::STATUS_REG_DATAPERUSAHAAN) {
            return redirect()->route('company.register.step2')->with('notyf_success', 'Silakan lengkapi dokumen perusahaan.');
        }

        return redirect()->route('company.dashboard')->with('notyf_success', 'Selamat datang di Dashboard Perusahaan.');
    }

    public function logout(Request $request)
    {
        Auth::guard('company')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('notyf_success', 'Anda berhasil keluar.');
    }

    public function showRegisterStep1()
    {
        $badanUsaha = BadanUsaha::where('deleted_badanusaha', '0')->get();
        $categories = CompanyCategory::where('deleted_category', '0')->get();
        return view('auth.company.register-step1', compact('badanUsaha', 'categories'));
    }

    public function submitRegisterStep1(Request $request)
    {
        $data = $request->validate([
            'name_company' => ['required', 'string', 'max:256'],
            'badanusaha_company' => ['required', 'integer'],
            'category_company' => ['required', 'integer'],
            'email_company' => ['required', 'email', 'max:128', 'unique:company,email_company'],
            'hp_company' => ['required', 'string', 'max:128'],
            'address_company' => ['required', 'string', 'max:256'],
            'pj_company' => ['required', 'string', 'max:128'],
            'cp_penanggungjawab' => ['required', 'string', 'max:128'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $company = Company::create([
            'name_company' => $data['name_company'],
            'badanusaha_company' => $data['badanusaha_company'],
            'category_company' => $data['category_company'],
            'email_company' => $data['email_company'],
            'password_company' => Hash::make($data['password']),
            'hp_company' => $data['hp_company'],
            'address_company' => $data['address_company'],
            'pj_company' => $data['pj_company'],
            'cp_penanggungjawab' => $data['cp_penanggungjawab'],
            'logo_company' => 'default.png',
            'legal_status' => '0',
            'is_activecompany' => 1,
            'status_regcompany' => SidutaConstants::STATUS_REG_DATAPERUSAHAAN,
            'deleted_company' => '0',
        ]);

        Auth::guard('company')->login($company);
        $request->session()->regenerate();

        return redirect()->route('company.register.step2')->with('notyf_success', 'Akun perusahaan dibuat. Lengkapi legalitas.');
    }

    public function showRegisterStep2()
    {
        $company = Auth::guard('company')->user();
        return view('auth.company.register-step2', compact('company'));
    }

    public function submitRegisterStep2(Request $request)
    {
        $company = Auth::guard('company')->user();
        $data = $request->validate([
            'npwp_company' => ['required', 'string', 'max:128'],
            'nib_company' => ['required', 'string', 'max:128'],
            'name_direktur' => ['required', 'string', 'max:255'],
            'jabatan_pj' => ['required', 'string', 'max:255'],
            'akta_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'logo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $update = [
            'npwp_company' => $data['npwp_company'],
            'nib_company' => $data['nib_company'],
            'name_direktur' => $data['name_direktur'],
            'jabatan_pj' => $data['jabatan_pj'],
            'status_regcompany' => SidutaConstants::STATUS_REG_COMDONE,
        ];

        if ($request->hasFile('akta_file')) {
            $update['akta_company'] = $request->file('akta_file')->store('uploads/company', 'public');
        }
        if ($request->hasFile('logo_file')) {
            $update['logo_company'] = $request->file('logo_file')->store('uploads/company', 'public');
        }

        $company->update($update);

        $this->notifier->notifyAdmin(
            'Perusahaan baru mendaftar & menunggu verifikasi: ' . $company->display_name,
            4,
            ['company_id' => $company->id_company, 'status_reg' => '1']
        );

        return redirect()->route('company.register.done');
    }

    public function showRegisterDone()
    {
        return view('auth.company.register-done');
    }
}
