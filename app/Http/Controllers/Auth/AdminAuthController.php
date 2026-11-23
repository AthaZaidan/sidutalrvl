<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserToken;
use App\Support\RecaptchaVerifier;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('web')->check() && (int) Auth::guard('web')->user()->role_id !== SidutaConstants::ANGKATAN_KERJA) {
            return redirect()->route(SidutaConstants::adminHomeRouteByRole((int) Auth::guard('web')->user()->role_id));
        }

        return view('auth.admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'inputEmail' => ['required', 'email'],
            'inputPassword' => ['required', 'string', 'min:3'],
        ]);

        if (!RecaptchaVerifier::verify($request)) {
            return back()->withInput()->with('flash_error', 'Mohon maaf, verifikasi reCAPTCHA gagal.');
        }

        $user = User::where('email', $credentials['inputEmail'])->where('deleted_user', '0')->first();

        if (!$user || (int) $user->role_id === SidutaConstants::ANGKATAN_KERJA) {
            return back()->withInput()->with('flash_error', 'Email tidak terdaftar sebagai akun Admin/Petugas.');
        }

        if ((int) $user->is_active !== 1) {
            return back()->withInput()->with('flash_error', 'Akun Anda tidak aktif. Silakan hubungi Administrator.');
        }

        if (!Hash::check($credentials['inputPassword'], $user->password)) {
            return back()->withInput()->with('flash_error', 'Email atau password salah.');
        }

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->route(SidutaConstants::adminHomeRouteByRole((int) $user->role_id));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('adm.login')->with('flash_success', 'Anda telah keluar dari sistem.');
    }

    public function showForgotPassword()
    {
        return view('auth.admin.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $data = $request->validate(['inputEmail' => ['required', 'email']]);
        $user = User::where('email', $data['inputEmail'])
            ->where('is_active', 1)
            ->where('role_id', '!=', SidutaConstants::ANGKATAN_KERJA)
            ->first();

        if (!$user) {
            return back()->with('flash_error', 'Email admin tidak terdaftar atau tidak aktif.');
        }

        $token = Str::random(48);
        UserToken::create([
            'email' => $user->email,
            'token' => $token,
            'date_created' => time(),
            'type' => SidutaConstants::TOKEN_RESET,
        ]);

        return redirect()->route('adm.reset_password', ['email' => $user->email, 'token' => $token])
            ->with('flash_success', 'Token reset password dibuat (mode lokal). Silakan masukkan password baru.');
    }

    public function showResetPassword(Request $request)
    {
        $email = (string) $request->query('email');
        $token = (string) $request->query('token');

        $record = UserToken::where('email', $email)->where('token', $token)->first();
        if (!$record || (time() - (int) $record->date_created) > 3600) {
            return redirect()->route('adm.login')->with('flash_error', 'Token reset password tidak valid atau kedaluwarsa.');
        }

        return view('auth.admin.reset-password', compact('email', 'token'));
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
            'password1' => ['required', 'string', 'min:6'],
            'password2' => ['required', 'same:password1'],
        ]);

        $record = UserToken::where('email', $data['email'])->where('token', $data['token'])->first();
        if (!$record || (time() - (int) $record->date_created) > 3600) {
            return redirect()->route('adm.login')->with('flash_error', 'Token reset password tidak valid atau kedaluwarsa.');
        }

        User::where('email', $data['email'])->update(['password' => Hash::make($data['password1'])]);
        UserToken::where('email', $data['email'])->delete();

        return redirect()->route('adm.login')->with('flash_success', 'Password berhasil diubah. Silakan login.');
    }
}
