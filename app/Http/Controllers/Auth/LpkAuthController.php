<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Lpk;
use App\Models\SectorPotential;
use App\Models\Vocational;
use App\Services\NotificationService;
use App\Support\RecaptchaVerifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LpkAuthController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function showLogin()
    {
        if (Auth::guard('lpk')->check()) {
            return redirect()->route('lpk.dashboard');
        }
        return view('auth.lpk.login');
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

        $lpk = Lpk::where('email_lpk', $data['inputEmail'])
            ->where('deleted_lpk', '0')
            ->first();

        if (!$lpk || !Hash::check($data['inputPassword'], $lpk->password_lpk)) {
            return back()->withInput()->with('notyf_error', 'Email atau password salah.');
        }

        if ((int) $lpk->is_activelpk !== 1) {
            return back()->withInput()->with('notyf_error', 'Akun LPK belum aktif.');
        }

        Auth::guard('lpk')->login($lpk);
        $request->session()->regenerate();

        if ((int) $lpk->legal_status === 0) {
            return redirect()->route('lpk.register.step2')->with('notyf_success', 'Silakan lengkapi dokumen LPK.');
        }

        return redirect()->route('lpk.dashboard')->with('notyf_success', 'Selamat datang di Dashboard LPK.');
    }

    public function logout(Request $request)
    {
        Auth::guard('lpk')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('notyf_success', 'Anda berhasil keluar.');
    }

    public function showRegisterStep1()
    {
        $sectors = SectorPotential::where('deleted_sector', '0')->get();
        $vocationals = Vocational::where('deleted_vocational', '0')->get();
        return view('auth.lpk.register-step1', compact('sectors', 'vocationals'));
    }

    public function submitRegisterStep1(Request $request)
    {
        $data = $request->validate([
            'name_lpk' => ['required', 'string', 'max:128'],
            'name_leader' => ['required', 'string', 'max:128'],
            'email_lpk' => ['required', 'email', 'max:128', 'unique:lpk,email_lpk'],
            'no_telp' => ['required', 'string', 'max:128'],
            'nohp_pimpinan' => ['required', 'string', 'max:128'],
            'address_lpk' => ['required', 'string', 'max:128'],
            'no_vin' => ['required', 'string', 'max:128'],
            'potential_sector_id' => ['required', 'integer'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $lpk = Lpk::create([
            'name_lpk' => $data['name_lpk'],
            'name_leader' => $data['name_leader'],
            'email_lpk' => $data['email_lpk'],
            'password_lpk' => Hash::make($data['password']),
            'no_telp' => $data['no_telp'],
            'nohp_pimpinan' => $data['nohp_pimpinan'],
            'address_lpk' => $data['address_lpk'],
            'no_vin' => $data['no_vin'],
            'potential_sector_id' => $data['potential_sector_id'],
            'logo_lpk' => 'default.png',
            'legal_status' => 0,
            'is_activelpk' => 1,
            'deleted_lpk' => '0',
        ]);

        Auth::guard('lpk')->login($lpk);
        $request->session()->regenerate();

        return redirect()->route('lpk.register.step2')->with('notyf_success', 'Akun LPK dibuat. Silakan unggah dokumen perizinan.');
    }

    public function showRegisterStep2()
    {
        $lpk = Auth::guard('lpk')->user();
        $vocationals = Vocational::where('deleted_vocational', '0')->get();
        return view('auth.lpk.register-step2', compact('lpk', 'vocationals'));
    }

    public function submitRegisterStep2(Request $request)
    {
        $lpk = Auth::guard('lpk')->user();
        $data = $request->validate([
            'no_izin_lpk' => ['required', 'string', 'max:100'],
            'no_akreditasi_lpk' => ['nullable', 'string', 'max:100'],
            'daya_tampung_lpk' => ['required', 'integer', 'min:1'],
            'count_staff' => ['required', 'integer', 'min:1'],
            'vocationals' => ['nullable', 'array'],
            'izin_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'akreditasi_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $update = [
            'no_izin_lpk' => $data['no_izin_lpk'],
            'no_akreditasi_lpk' => $data['no_akreditasi_lpk'] ?? null,
            'daya_tampung_lpk' => $data['daya_tampung_lpk'],
            'count_staff' => $data['count_staff'],
            'legal_status' => 2,
        ];

        if ($request->hasFile('izin_file')) {
            $update['izin_lpk'] = $request->file('izin_file')->store('uploads/lpk', 'public');
        }
        if ($request->hasFile('akreditasi_file')) {
            $update['akreditasi_lpk'] = $request->file('akreditasi_file')->store('uploads/lpk', 'public');
        }

        $lpk->update($update);

        DB::table('lpk_listvocational')->where('lpk_id', $lpk->id_lpk)->delete();
        foreach ($data['vocationals'] ?? [] as $vocId) {
            DB::table('lpk_listvocational')->insert([
                'lpk_id' => $lpk->id_lpk,
                'vocational_id' => (int) $vocId,
            ]);
        }

        $this->notifier->notifyAdmin(
            'LPK baru mendaftar & menunggu verifikasi: ' . $lpk->name_lpk,
            4,
            ['lpk_id' => $lpk->id_lpk, 'status_reg' => '1']
        );

        return redirect()->route('lpk.register.done');
    }

    public function showRegisterDone()
    {
        return view('auth.lpk.register-done');
    }
}
