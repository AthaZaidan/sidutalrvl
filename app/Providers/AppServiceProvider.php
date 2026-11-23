<?php

namespace App\Providers;

use App\Models\ClientNotification;
use App\Models\UserMenu;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('layouts.admin', function ($view) {
            $adminUser = Auth::guard('web')->user();
            $sidebarMenus = collect();

            if ($adminUser) {
                $roleId = (int) $adminUser->role_id;
                $menuIds = DB::table('user_access_menu')
                    ->where('role_id', $roleId)
                    ->pluck('menu_id');

                $sidebarMenus = UserMenu::query()
                    ->whereIn('id', $menuIds)
                    ->orderBy('position')
                    ->with(['subMenus' => fn ($q) => $q->where('is_active', 1)->orderBy('id')])
                    ->get();
            }

            $view->with([
                'adminUser' => $adminUser,
                'sidebarMenus' => $sidebarMenus,
            ]);
        });

        View::composer('layouts.main', function ($view) {
            $unreadNotifCount = 0;
            if (Auth::guard('company')->check()) {
                $unreadNotifCount = ClientNotification::where('company_id', Auth::guard('company')->id())
                    ->where('deleted_notif', '0')
                    ->where('status_read', '0')
                    ->count();
            } elseif (Auth::guard('lpk')->check()) {
                $unreadNotifCount = ClientNotification::where('lpk_id', Auth::guard('lpk')->id())
                    ->where('deleted_notif', '0')
                    ->where('status_read', '0')
                    ->count();
            } elseif (Auth::guard('web')->check()) {
                $unreadNotifCount = ClientNotification::where('user_id', Auth::guard('web')->id())
                    ->where('deleted_notif', '0')
                    ->where('status_read', '0')
                    ->count();
            }

            $view->with('unreadNotifCount', $unreadNotifCount);
        });
    }
}
