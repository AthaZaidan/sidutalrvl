<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JumlahKaryawanLpk;
use App\Models\KegiatanP2Lpk;
use App\Models\KemitraanLpk;
use App\Models\KendalaLpk;

class LpkReportController extends Controller
{
    public function index()
    {
        return view('admin.management.reports.lpk', [
            'activeMenu' => 'Management',
            'karyawan' => JumlahKaryawanLpk::with('lpk')->where('is_deleted', 0)->get(),
            'p2' => KegiatanP2Lpk::with('lpk')->where('is_deleted', 0)->get(),
            'kemitraan' => KemitraanLpk::with('lpk')->where('is_deleted', 0)->get(),
            'kendala' => KendalaLpk::with('lpk')->where('is_deleted', 0)->get(),
        ]);
    }

    public function toggleLock(int $id)
    {
        $row = JumlahKaryawanLpk::findOrFail($id);
        $row->update(['is_locked' => $row->is_locked ? 0 : 1]);
        return back()->with('flash_success', 'Status kunci laporan LPK diperbarui.');
    }
}
