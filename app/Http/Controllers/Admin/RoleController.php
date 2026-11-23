<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserAccessMenu;
use App\Models\UserMenu;
use App\Models\UserRole;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = UserRole::orderBy('id_role')->get();
        return view('admin.roles.index', ['activeMenu' => 'Administrator', 'roles' => $roles]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['role' => ['required', 'string', 'max:128', 'unique:user_role,role']]);
        UserRole::create($data);
        return back()->with('flash_success', 'Role baru berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        if ($id === 1) {
            return back()->with('flash_error', 'Role Super Administrator tidak dapat diubah.');
        }
        $data = $request->validate(['role' => ['required', 'string', 'max:128']]);
        UserRole::where('id_role', $id)->update(['role' => $data['role']]);
        return back()->with('flash_success', 'Role diperbarui.');
    }

    public function destroy(int $id)
    {
        if (in_array($id, [1, 2], true)) {
            return back()->with('flash_error', 'Role inti tidak dapat dihapus.');
        }
        UserRole::where('id_role', $id)->delete();
        UserAccessMenu::where('role_id', $id)->delete();
        return back()->with('flash_success', 'Role dihapus.');
    }

    public function access(int $id)
    {
        $role = UserRole::where('id_role', $id)->firstOrFail();
        $menus = UserMenu::orderBy('position')->get();
        $grantedIds = UserAccessMenu::where('role_id', $id)->pluck('menu_id')->all();

        return view('admin.roles.access', [
            'activeMenu' => 'Administrator',
            'role' => $role,
            'menus' => $menus,
            'grantedIds' => $grantedIds,
        ]);
    }

    public function toggleAccess(Request $request)
    {
        $data = $request->validate([
            'role_id' => ['required', 'integer'],
            'menu_id' => ['required', 'integer'],
        ]);

        $existing = UserAccessMenu::where($data)->first();
        if ($existing) {
            $existing->delete();
        } else {
            UserAccessMenu::create($data);
        }

        if ($request->expectsJson()) {
            return response()->json(['status' => 'ok']);
        }
        return back()->with('flash_success', 'Hak akses menu diperbarui.');
    }
}
