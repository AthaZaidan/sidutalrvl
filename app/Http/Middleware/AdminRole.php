<?php

namespace App\Http\Middleware;

use App\Support\SidutaConstants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->route('adm.login');
        }

        $roleId = (int) $user->role_id;
        if ($roleId === SidutaConstants::SUPER_ADMIN) {
            return $next($request);
        }

        $allowed = array_map('intval', $roles);
        if (!in_array($roleId, $allowed, true)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            return redirect()->route('adm.user.index')->with('flash_error', 'Maaf, Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
