<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PermohonanPkb;
use App\Models\PermohonanPkwt;
use App\Models\PermohonanPp;
use App\Models\Serikat;
use App\Models\Wlkp;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelayananController extends Controller
{
    public function index()
    {
        return view('admin.management.pelayanan.index', [
            'activeMenu' => 'Management',
            'pps' => PermohonanPp::with('company.badanUsaha')->where('is_deleted', 0)->orderByDesc('id_pp')->get(),
            'pkwts' => PermohonanPkwt::with('company.badanUsaha')->where('is_deleted', 0)->orderByDesc('id_pkwt')->get(),
            'pkbs' => PermohonanPkb::with('company.badanUsaha')->where('is_deleted', 0)->orderByDesc('id_pkb')->get(),
            'wlkps' => Wlkp::with('company.badanUsaha')->orderByDesc('id_wlkp')->limit(50)->get(),
            'serikats' => Serikat::with('company.badanUsaha')->orderByDesc('id_serikat')->limit(50)->get(),
            'karyawanCount' => Karyawan::count(),
        ]);
    }

    public function verify(Request $request, string $type, int $id)
    {
        $model = match ($type) {
            'pp' => PermohonanPp::findOrFail($id),
            'pkwt' => PermohonanPkwt::findOrFail($id),
            'pkb' => PermohonanPkb::findOrFail($id),
            default => abort(404),
        };

        $user = Auth::guard('web')->user();
        $roleId = (int) $user->role_id;
        $action = $request->input('action', 'approve');

        if ($action === 'decline') {
            $model->update([
                'process_status' => SidutaConstants::HI_DECLINED,
                'decline_reason' => (string) $request->input('reason', 'Berkas belum lengkap'),
                'updated_by' => $user->id,
                'updated_at' => now(),
            ]);
            return back()->with('flash_success', 'Permohonan HI ditolak.');
        }

        if ($roleId === SidutaConstants::BPJS_KETENAGAKERJAAN) {
            $model->update(['bpjs_tk_status' => 1, 'updated_by' => $user->id, 'updated_at' => now()]);
        } elseif ($roleId === SidutaConstants::BPJS_KESEHATAN) {
            $model->update(['bpjs_ks_status' => 1, 'updated_by' => $user->id, 'updated_at' => now()]);
        } elseif ($roleId === SidutaConstants::MEDIATOR) {
            $model->update(['mediator_status' => 1, 'process_status' => SidutaConstants::HI_ASSIGNED_MEDIATOR, 'mediator' => $user->id, 'updated_by' => $user->id, 'updated_at' => now()]);
        } else {
            $model->update([
                'process_status' => SidutaConstants::HI_APPROVED,
                'published_date' => now()->toDateString(),
                'updated_by' => $user->id,
                'updated_at' => now(),
            ]);
        }

        return back()->with('flash_success', 'Verifikasi Pelayanan HI berhasil disimpan.');
    }
}
