<?php

namespace App\Http\Middleware;

use App\Support\SidutaConstants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JobseekerAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();

        if (!$user || (int) $user->role_id !== SidutaConstants::ANGKATAN_KERJA) {
            return redirect()->route('jobseeker.login')->with('notyf_error', 'Silakan login sebagai Pencari Kerja.');
        }

        $regStatus = (int) $user->reg_status;
        if ($regStatus < SidutaConstants::STATUS_REG_JSDONE && !$request->routeIs('jobseeker.register*')) {
            $step = match ($regStatus) {
                SidutaConstants::STATUS_REG_DATADIRI => 2,
                SidutaConstants::STATUS_REG_SPESIALISASI => 3,
                SidutaConstants::STATUS_REG_PENDIDIKAN => 4,
                default => 2,
            };
            return redirect()->route("jobseeker.register.step{$step}")
                ->with('notyf_success', 'Silakan lengkapi data registrasi Anda.');
        }

        return $next($request);
    }
}
