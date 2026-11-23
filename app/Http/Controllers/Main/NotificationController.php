<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\ClientNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private function scopeQuery()
    {
        if (Auth::guard('company')->check()) {
            return ClientNotification::where('company_id', Auth::guard('company')->id())->where('deleted_notif', '0');
        }
        if (Auth::guard('lpk')->check()) {
            return ClientNotification::where('lpk_id', Auth::guard('lpk')->id())->where('deleted_notif', '0');
        }
        if (Auth::guard('web')->check()) {
            return ClientNotification::where('user_id', Auth::guard('web')->id())->where('deleted_notif', '0');
        }
        return null;
    }

    public function index()
    {
        $query = $this->scopeQuery();
        if (!$query) {
            return redirect()->route('home');
        }

        $notifications = (clone $query)->orderByDesc('id_notif')->paginate(20);
        (clone $query)->where('status_read', '0')->update(['status_read' => '1']);

        return view('public.notifications.index', compact('notifications'));
    }

    public function summary()
    {
        $query = $this->scopeQuery();
        $count = $query ? (clone $query)->where('status_read', '0')->count() : 0;

        return response()->json(['data' => $count]);
    }
}
