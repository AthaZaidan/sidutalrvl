<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LpkAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $lpk = Auth::guard('lpk')->user();

        if (!$lpk) {
            return redirect()->route('lpk.login')->with('notyf_error', 'Silakan login sebagai LPK.');
        }

        if ((int) $lpk->legal_status === 0 && !$request->routeIs('lpk.register*')) {
            return redirect()->route('lpk.register.step2')
                ->with('notyf_success', 'Silakan lengkapi dokumen perizinan LPK.');
        }

        return $next($request);
    }
}
