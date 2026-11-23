<?php

namespace App\Http\Controllers\Lpk;

use App\Http\Controllers\Controller;
use App\Models\JumlahKaryawanLpk;
use App\Models\KegiatanP2Lpk;
use App\Models\KegiatanP2TukLpk;
use App\Models\KegiatanP3Lpk;
use App\Models\KegiatanPksdmLpk;
use App\Models\KegiatanPukLpk;
use App\Models\KemitraanLpk;
use App\Models\KendalaLpk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $lpk = Auth::guard('lpk')->user();
        $id = $lpk->id_lpk;

        return view('lpk.reports.index', [
            'lpk' => $lpk,
            'karyawan' => JumlahKaryawanLpk::where('lpk_id', $id)->where('is_deleted', 0)->get(),
            'p2' => KegiatanP2Lpk::where('lpk_id', $id)->where('is_deleted', 0)->get(),
            'p2tuk' => KegiatanP2TukLpk::where('lpk_id', $id)->where('is_deleted', 0)->get(),
            'p3' => KegiatanP3Lpk::where('lpk_id', $id)->where('is_deleted', 0)->get(),
            'pksdm' => KegiatanPksdmLpk::where('lpk_id', $id)->where('is_deleted', 0)->get(),
            'puk' => KegiatanPukLpk::where('lpk_id', $id)->where('is_deleted', 0)->get(),
            'kemitraan' => KemitraanLpk::where('lpk_id', $id)->where('is_deleted', 0)->get(),
            'kendala' => KendalaLpk::where('lpk_id', $id)->where('is_deleted', 0)->get(),
        ]);
    }

    public function store(Request $request, string $section)
    {
        $lpk = Auth::guard('lpk')->user();
        $base = [
            'lpk_id' => $lpk->id_lpk,
            'sms' => (int) $request->input('sms', 1),
            'yr1' => (int) $request->input('yr1', date('Y')),
            'yr2' => (int) $request->input('yr2', date('Y')),
            'is_deleted' => 0,
            'is_locked' => 0,
        ];

        match ($section) {
            'karyawan' => JumlahKaryawanLpk::create(array_merge($base, $request->validate([
                'tpt_lk' => ['required', 'integer', 'min:0'],
                'tpt_p' => ['required', 'integer', 'min:0'],
                'it_lk' => ['required', 'integer', 'min:0'],
                'it_p' => ['required', 'integer', 'min:0'],
                'ket_tpt' => ['nullable', 'string', 'max:255'],
            ]))),
            'p2' => KegiatanP2Lpk::create(array_merge($base, $request->validate([
                'nama_pelatihan' => ['required', 'string', 'max:255'],
                'jadwal_pelatihan' => ['required', 'date'],
                'jumlah_pesertalat' => ['required', 'integer', 'min:0'],
                'jumlah_lulusanlat' => ['required', 'integer', 'min:0'],
                'jumlah_lulusanker' => ['required', 'integer', 'min:0'],
                'jumlah_lulusanwir' => ['required', 'integer', 'min:0'],
            ]))),
            'p2tuk' => KegiatanP2TukLpk::create(array_merge($base, $request->validate([
                'kejuruan_tuk' => ['required', 'string', 'max:255'],
                'sertifikasi_tuk' => ['required', 'string', 'max:255'],
                'kapasitas_tuk' => ['required', 'integer', 'min:0'],
                'lsp_tuk' => ['required', 'string', 'max:255'],
            ]))),
            'p3' => KegiatanP3Lpk::create(array_merge($base, $request->validate([
                'nama_program' => ['required', 'string', 'max:255'],
                'inisiator_pemohon' => ['required', 'string', 'max:255'],
                'durasi_pelatihan' => ['required', 'integer', 'min:1'],
                'standar_kompetensi' => ['required', 'string', 'max:255'],
            ]))),
            'pksdm' => KegiatanPksdmLpk::create(array_merge($base, $request->validate([
                'nama_kegiatan' => ['required', 'string', 'max:255'],
                'jadwal' => ['required', 'date'],
                'lokasi' => ['required', 'string', 'max:255'],
                'penyelenggara' => ['required', 'string', 'max:255'],
            ]))),
            'puk' => KegiatanPukLpk::create(array_merge($base, $request->validate([
                'nama_lps' => ['required', 'string', 'max:255'],
                'skema_sertifikasi' => ['required', 'string', 'max:255'],
                'jadwal_pelaksanaan' => ['required', 'date'],
                'jumlah_pesertauji' => ['required', 'integer', 'min:0'],
                'jumlah_kompeten' => ['required', 'integer', 'min:0'],
            ]))),
            'kemitraan' => KemitraanLpk::create(array_merge($base, $request->validate([
                'nama_mitra' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string', 'max:255'],
                'bentuk_kemitraan' => ['required', 'string', 'max:255'],
            ]))),
            'kendala' => KendalaLpk::create(array_merge($base, $request->validate([
                'kendala' => ['required', 'string', 'max:255'],
                'solusi' => ['required', 'string', 'max:255'],
                'ket_kendala' => ['nullable', 'string', 'max:255'],
            ]))),
            default => abort(404),
        };

        return back()->with('notyf_success', 'Laporan semester LPK berhasil disimpan.');
    }
}
