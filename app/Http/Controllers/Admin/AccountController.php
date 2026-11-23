<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Lpk;
use App\Models\User;
use App\Models\UserRole;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'staff');
        $staff = User::with('role')->where('role_id', '!=', SidutaConstants::ANGKATAN_KERJA)->where('deleted_user', '0')->orderByDesc('id')->paginate(15, ['*'], 'staff_page');
        $jobseekers = User::where('role_id', SidutaConstants::ANGKATAN_KERJA)->where('deleted_user', '0')->orderByDesc('id')->paginate(15, ['*'], 'js_page');
        $companies = Company::with('badanUsaha')->where('deleted_company', '0')->orderByDesc('id_company')->paginate(15, ['*'], 'comp_page');
        $lpks = Lpk::where('deleted_lpk', '0')->orderByDesc('id_lpk')->paginate(15, ['*'], 'lpk_page');
        $roles = UserRole::orderBy('id_role')->get();

        return view('admin.accounts.index', [
            'activeMenu' => 'Akun',
            'tab' => $tab,
            'staff' => $staff,
            'jobseekers' => $jobseekers,
            'companies' => $companies,
            'lpks' => $lpks,
            'roles' => $roles,
        ]);
    }

    public function storeStaff(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:128'],
            'last_name' => ['nullable', 'string', 'max:128'],
            'email' => ['required', 'email', 'unique:user,email'],
            'role_id' => ['required', 'integer'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? '',
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'password' => Hash::make($data['password']),
            'image' => 'default.jpg',
            'is_active' => 1,
            'reg_status' => 3,
            'date_create' => time(),
            'deleted_user' => '0',
        ]);

        return back()->with('flash_success', 'Akun petugas berhasil ditambahkan.');
    }

    public function toggleUser(int $id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => $user->is_active ? 0 : 1]);
        return back()->with('flash_success', 'Status aktif pengguna diperbarui.');
    }

    public function toggleCompany(int $id)
    {
        $company = Company::findOrFail($id);
        $company->update(['is_activecompany' => $company->is_activecompany ? 0 : 1]);
        return back()->with('flash_success', 'Status aktif perusahaan diperbarui.');
    }

    public function toggleLpk(int $id)
    {
        $lpk = Lpk::findOrFail($id);
        $lpk->update(['is_activelpk' => $lpk->is_activelpk ? 0 : 1]);
        return back()->with('flash_success', 'Status aktif LPK diperbarui.');
    }
}
