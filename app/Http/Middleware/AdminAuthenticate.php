<?php

namespace App\Http\Middleware;

use App\Support\SidutaConstants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();

        if (!$user || (int) $user->is_active !== 1 || (int) $user->role_id === SidutaConstants::ANGKATAN_KERJA) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('adm.login')->with('flash_error', 'Silakan login sebagai Admin/Petugas Disnaker.');
        }

        return $next($request);
    }
}
