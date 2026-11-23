<?php

namespace App\Http\Middleware;

use App\Support\SidutaConstants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CompanyAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $company = Auth::guard('company')->user();

        if (!$company) {
            return redirect()->route('company.login')->with('notyf_error', 'Silakan login sebagai Perusahaan.');
        }

        if ((int) $company->status_regcompany === SidutaConstants::STATUS_REG_DATAPERUSAHAAN && !$request->routeIs('company.register*')) {
            return redirect()->route('company.register.step2')
                ->with('notyf_success', 'Silakan lengkapi dokumen legalitas perusahaan.');
        }

        return $next($request);
    }
}
