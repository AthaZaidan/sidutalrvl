<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\SubtypeNotification;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user()->load('role');
        return view('admin.profile.index', ['activeMenu' => 'User', 'user' => $user]);
    }

    public function edit()
    {
        $user = Auth::guard('web')->user();
        return view('admin.profile.edit', ['activeMenu' => 'User', 'user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::guard('web')->user();
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:128'],
            'last_name' => ['nullable', 'string', 'max:128'],
            'no_handphone' => ['nullable', 'string', 'max:32'],
        ]);
        $user->update($data);
        return redirect()->route('adm.user.index')->with('flash_success', 'Profil admin diperbarui.');
    }

    public function changePasswordForm()
    {
        return view('admin.profile.password', ['activeMenu' => 'User']);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::guard('web')->user();
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->with('flash_error', 'Password saat ini tidak sesuai.');
        }

        $user->update(['password' => Hash::make($data['new_password'])]);
        return back()->with('flash_success', 'Password berhasil diubah.');
    }

    public function notifications()
    {
        $user = Auth::guard('web')->user();
        $subtypes = SubtypeNotification::where('role_id', $user->role_id)
            ->where('deleted_subtype', '0')
            ->pluck('id_subtype');

        $query = Notification::query()->orderByDesc('id_notif');
        if ((int) $user->role_id !== SidutaConstants::SUPER_ADMIN && $subtypes->isNotEmpty()) {
            $query->whereIn('subtype_notif', $subtypes);
        }

        $notifications = $query->paginate(20);
        return view('admin.notifications.index', ['activeMenu' => 'User', 'notifications' => $notifications]);
    }

    public function notificationsJson()
    {
        $user = Auth::guard('web')->user();
        $subtypes = SubtypeNotification::where('role_id', $user->role_id)
            ->where('deleted_subtype', '0')
            ->pluck('id_subtype');

        $query = Notification::where('status_read', '0')->orderByDesc('id_notif');
        if ((int) $user->role_id !== SidutaConstants::SUPER_ADMIN && $subtypes->isNotEmpty()) {
            $query->whereIn('subtype_notif', $subtypes);
        }

        $list = $query->limit(8)->get();
        return response()->json([
            'sumNotif' => $list->count(),
            'data' => $list,
        ]);
    }
}
