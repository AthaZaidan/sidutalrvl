<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Lpk;
use App\Models\RegisterLog;
use App\Models\User;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterVerificationController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function jobseekers()
    {
        $users = User::where('role_id', SidutaConstants::ANGKATAN_KERJA)->where('deleted_user', '0')->orderByDesc('id')->paginate(15);
        return view('admin.registrations.jobseekers', ['activeMenu' => 'Registrasi', 'users' => $users]);
    }

    public function companies()
    {
        $companies = Company::with(['badanUsaha', 'category'])->where('deleted_company', '0')->orderByDesc('id_company')->paginate(15);
        return view('admin.registrations.companies', ['activeMenu' => 'Registrasi', 'companies' => $companies]);
    }

    public function lpks()
    {
        $lpks = Lpk::with('sectorPotential')->where('deleted_lpk', '0')->orderByDesc('id_lpk')->paginate(15);
        return view('admin.registrations.lpks', ['activeMenu' => 'Registrasi', 'lpks' => $lpks]);
    }

    public function verifyCompany(Request $request, int $id)
    {
        $company = Company::findOrFail($id);
        $status = (string) $request->input('legal_status', '1');
        $company->update(['legal_status' => $status, 'is_activecompany' => 1]);

        RegisterLog::create([
            'name_log' => ($status === '1' ? 'Menyetujui' : 'Menolak') . ' legalitas perusahaan: ' . $company->display_name,
            'user_id' => (string) $company->id_company,
            'adminreg_id' => Auth::guard('web')->id(),
        ]);

        $this->notifier->notifyClient(
            $status === '1' ? 'Akun perusahaan Anda telah diverifikasi oleh Disnaker Kota Medan.' : 'Pengajuan verifikasi perusahaan ditolak.',
            null,
            $company->id_company
        );

        return back()->with('flash_success', 'Status verifikasi perusahaan diperbarui.');
    }

    public function verifyLpk(Request $request, int $id)
    {
        $lpk = Lpk::findOrFail($id);
        $status = (int) $request->input('legal_status', 3);
        $lpk->update(['legal_status' => $status, 'is_activelpk' => 1]);

        RegisterLog::create([
            'name_log' => ($status === 3 ? 'Menyetujui' : 'Menolak') . ' legalitas LPK: ' . $lpk->name_lpk,
            'user_id' => (string) $lpk->id_lpk,
            'adminreg_id' => Auth::guard('web')->id(),
        ]);

        $this->notifier->notifyClient(
            $status === 3 ? 'Akun LPK Anda telah disetujui oleh Disnaker Kota Medan.' : 'Pengajuan verifikasi LPK ditolak.',
            null,
            null,
            $lpk->id_lpk
        );

        return back()->with('flash_success', 'Status verifikasi LPK diperbarui.');
    }
}
