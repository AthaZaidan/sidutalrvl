<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserMenu;
use App\Models\UserSubMenu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = UserMenu::orderBy('position')->get();
        return view('admin.settings.menus', ['activeMenu' => 'Settings', 'menus' => $menus]);
    }

    public function storeMenu(Request $request)
    {
        $data = $request->validate([
            'menu' => ['required', 'string', 'max:128'],
            'position' => ['required', 'integer', 'min:1'],
        ]);
        UserMenu::create($data);
        return back()->with('flash_success', 'Menu ditambahkan.');
    }

    public function submenus()
    {
        $menus = UserMenu::orderBy('position')->get();
        $submenus = UserSubMenu::with('menu')->orderBy('menu_id')->orderBy('id')->get();
        return view('admin.settings.submenus', ['activeMenu' => 'Settings', 'menus' => $menus, 'submenus' => $submenus]);
    }

    public function storeSubmenu(Request $request)
    {
        $data = $request->validate([
            'menu_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:128'],
            'url' => ['required', 'string', 'max:128'],
            'icon' => ['required', 'string', 'max:256'],
        ]);
        UserSubMenu::create(array_merge($data, ['is_active' => $request->boolean('is_active', true) ? 1 : 0]));
        return back()->with('flash_success', 'Submenu ditambahkan.');
    }

    public function toggleSubmenu(int $id)
    {
        $sm = UserSubMenu::findOrFail($id);
        $sm->update(['is_active' => $sm->is_active ? 0 : 1]);
        return back()->with('flash_success', 'Status submenu diubah.');
    }
}
