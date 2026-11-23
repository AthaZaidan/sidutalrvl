<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Lpk;
use App\Models\User;
use App\Models\UserToken;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.password.forgot');
    }

    public function sendResetToken(Request $request)
    {
        $data = $request->validate([
            'account_type' => ['required', 'in:jobseeker,company,lpk'],
            'email' => ['required', 'email'],
        ]);

        $exists = match ($data['account_type']) {
            'company' => Company::where('email_company', $data['email'])->exists(),
            'lpk' => Lpk::where('email_lpk', $data['email'])->exists(),
            default => User::where('email', $data['email'])->where('role_id', SidutaConstants::ANGKATAN_KERJA)->exists(),
        };

        if (!$exists) {
            return back()->with('notyf_error', 'Email tidak ditemukan.');
        }

        $token = Str::random(48);
        UserToken::create([
            'email' => $data['email'],
            'token' => $token,
            'date_created' => time(),
            'type' => SidutaConstants::TOKEN_RESET,
        ]);

        return redirect()->route('password.reset', [
            'account_type' => $data['account_type'],
            'email' => $data['email'],
            'token' => $token,
        ])->with('notyf_success', 'Token reset password dibuat. Silakan isi password baru.');
    }

    public function showResetForm(Request $request)
    {
        return view('auth.password.reset', [
            'account_type' => $request->query('account_type', 'jobseeker'),
            'email' => $request->query('email'),
            'token' => $request->query('token'),
        ]);
    }

    public function reset(Request $request)
    {
        $data = $request->validate([
            'account_type' => ['required', 'in:jobseeker,company,lpk'],
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $record = UserToken::where('email', $data['email'])->where('token', $data['token'])->first();
        if (!$record || (time() - (int) $record->date_created) > 3600) {
            return back()->with('notyf_error', 'Token tidak valid atau sudah kedaluwarsa.');
        }

        $hashed = Hash::make($data['password']);
        match ($data['account_type']) {
            'company' => Company::where('email_company', $data['email'])->update(['password_company' => $hashed]),
            'lpk' => Lpk::where('email_lpk', $data['email'])->update(['password_lpk' => $hashed]),
            default => User::where('email', $data['email'])->update(['password' => $hashed]),
        };

        UserToken::where('email', $data['email'])->delete();

        $loginRoute = match ($data['account_type']) {
            'company' => 'company.login',
            'lpk' => 'lpk.login',
            default => 'jobseeker.login',
        };

        return redirect()->route($loginRoute)->with('notyf_success', 'Password berhasil diubah. Silakan login.');
    }
}
