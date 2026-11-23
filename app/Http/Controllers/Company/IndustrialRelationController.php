<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyStatusModal;
use App\Models\EducationLevel;
use App\Models\Karyawan;
use App\Models\PermohonanPkb;
use App\Models\PermohonanPkwt;
use App\Models\PermohonanPp;
use App\Models\Serikat;
use App\Models\Wlkp;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndustrialRelationController extends Controller
{
    public function karyawan()
    {
        $company = Auth::guard('company')->user();
        $employees = Karyawan::where('company_id', $company->id_company)->orderByDesc('id')->paginate(15);
        $educationLevels = EducationLevel::where('deleted_educationlevel', '0')->get();
        return view('company.industrial-relations.karyawan', compact('company', 'employees', 'educationLevels'));
    }

    public function storeKaryawan(Request $request)
    {
        $company = Auth::guard('company')->user();
        $data = $request->validate([
            'identity' => ['required', 'string', 'max:100'],
            'nama' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'in:1,2'],
            'tgl_lahir' => ['required', 'date'],
            'tmpt_lahir' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'education' => ['required', 'integer'],
            'salary' => ['required', 'integer', 'min:0'],
            'is_bpjs_tk' => ['nullable', 'boolean'],
            'is_bpjs_kesehatan' => ['nullable', 'boolean'],
        ]);

        Karyawan::create([
            'company_id' => $company->id_company,
            'identity' => $data['identity'],
            'nama' => $data['nama'],
            'sex' => (int) $data['sex'],
            'tgl_lahir' => $data['tgl_lahir'],
            'tmpt_lahir' => $data['tmpt_lahir'],
            'jabatan' => $data['jabatan'],
            'education' => (int) $data['education'],
            'salary' => (int) $data['salary'],
            'is_bpjs_tk' => $request->boolean('is_bpjs_tk') ? 1 : 0,
            'is_bpjs_kesehatan' => $request->boolean('is_bpjs_kesehatan') ? 1 : 0,
            'is_active' => 1,
        ]);

        return back()->with('notyf_success', 'Data karyawan ditambahkan.');
    }

    public function wlkp()
    {
        $company = Auth::guard('company')->user();
        $wlkps = Wlkp::where('company_id', $company->id_company)->orderByDesc('id_wlkp')->get();
        $serikats = Serikat::where('company_id', $company->id_company)->orderByDesc('id_serikat')->get();
        return view('company.industrial-relations.wlkp', compact('company', 'wlkps', 'serikats'));
    }

    public function storeWlkp(Request $request)
    {
        $company = Auth::guard('company')->user();
        $data = $request->validate([
            'no_wlkp' => ['required', 'string', 'max:255'],
            'tahun_wlkp' => ['required', 'string', 'max:4'],
            'file_lampiran' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $path = $request->hasFile('file_lampiran') ? $request->file('file_lampiran')->store('uploads/wlkp', 'public') : '';

        Wlkp::create([
            'company_id' => $company->id_company,
            'no_wlkp' => $data['no_wlkp'],
            'tahun_wlkp' => $data['tahun_wlkp'],
            'file_lampiran' => $path,
            'created_by' => $company->id_company,
        ]);

        return back()->with('notyf_success', 'Data WLKP tersimpan.');
    }

    public function storeSerikat(Request $request)
    {
        $company = Auth::guard('company')->user();
        $data = $request->validate([
            'nama_serikat' => ['required', 'string', 'max:255'],
            'no_serikat_reg' => ['nullable', 'string', 'max:100'],
            'address_serikat' => ['nullable', 'string'],
            'jumlah_anggota' => ['required', 'integer', 'min:0'],
        ]);

        Serikat::create(array_merge($data, ['company_id' => $company->id_company]));
        return back()->with('notyf_success', 'Data Serikat Pekerja tersimpan.');
    }

    public function pelayanan()
    {
        $company = Auth::guard('company')->user();
        $statusModals = CompanyStatusModal::where('is_deleted', 0)->get();
        $pps = PermohonanPp::where('company_id', $company->id_company)->where('is_deleted', 0)->orderByDesc('id_pp')->get();
        $pkwts = PermohonanPkwt::where('company_id', $company->id_company)->where('is_deleted', 0)->orderByDesc('id_pkwt')->get();
        $pkbs = PermohonanPkb::where('company_id', $company->id_company)->where('is_deleted', 0)->orderByDesc('id_pkb')->get();

        return view('company.industrial-relations.pelayanan', compact('company', 'statusModals', 'pps', 'pkwts', 'pkbs'));
    }

    public function storePp(Request $request)
    {
        $company = Auth::guard('company')->user();
        $data = $request->validate([
            'npp' => ['required', 'string', 'max:255', 'unique:permohonan_pp,npp'],
            'kode_badan_usaha' => ['required', 'string', 'max:255', 'unique:permohonan_pp,kode_badan_usaha'],
            'nib' => ['required', 'string', 'max:255', 'unique:permohonan_pp,nib'],
            'status_modal_company' => ['nullable', 'integer'],
            'bidang_usaha' => ['required', 'string', 'max:255'],
            'tgl_surat_izin' => ['required', 'date'],
            'upah_min' => ['required', 'integer', 'min:0'],
            'upah_max' => ['required', 'integer', 'min:0'],
            'file_naskah_pp' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $fileNaskah = $request->hasFile('file_naskah_pp') ? $request->file('file_naskah_pp')->store('uploads/hi', 'public') : null;

        PermohonanPp::create([
            'company_id' => $company->id_company,
            'npp' => $data['npp'],
            'kode_badan_usaha' => $data['kode_badan_usaha'],
            'nib' => $data['nib'],
            'status_modal_company' => $data['status_modal_company'] ?? null,
            'bidang_usaha' => $data['bidang_usaha'],
            'tgl_surat_izin' => $data['tgl_surat_izin'],
            'upah_min' => $data['upah_min'],
            'upah_max' => $data['upah_max'],
            'has_sp_sb' => $request->boolean('has_sp_sb') ? 1 : 0,
            'file_naskah_pp' => $fileNaskah,
            'process_status' => SidutaConstants::HI_SUBMITTED,
            'created_by' => $company->id_company,
            'updated_by' => $company->id_company,
        ]);

        return back()->with('notyf_success', 'Permohonan Peraturan Perusahaan (PP) berhasil diajukan.');
    }

    public function storePkwt(Request $request)
    {
        $company = Auth::guard('company')->user();
        $data = $request->validate([
            'pemberi_kerja' => ['required', 'string', 'max:255'],
            'penerima_kerja' => ['required', 'string', 'max:255'],
            'npp' => ['required', 'string', 'max:100', 'unique:permohonan_pkwt,npp'],
            'kode_badan_usaha' => ['required', 'string', 'max:100', 'unique:permohonan_pkwt,kode_badan_usaha'],
            'perjanjian_kerja_file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $filePkwt = $request->hasFile('perjanjian_kerja_file') ? $request->file('perjanjian_kerja_file')->store('uploads/hi', 'public') : null;

        PermohonanPkwt::create([
            'company_id' => $company->id_company,
            'pemberi_kerja' => $data['pemberi_kerja'],
            'penerima_kerja' => $data['penerima_kerja'],
            'npp' => $data['npp'],
            'kode_badan_usaha' => $data['kode_badan_usaha'],
            'perjanjian_kerja_file' => $filePkwt,
            'process_status' => SidutaConstants::HI_SUBMITTED,
            'created_by' => $company->id_company,
            'updated_by' => $company->id_company,
        ]);

        return back()->with('notyf_success', 'Permohonan pencatatan PKWT berhasil diajukan.');
    }

    public function storePkb(Request $request)
    {
        $company = Auth::guard('company')->user();
        $data = $request->validate([
            'tahun_company' => ['required', 'string', 'max:4'],
            'npp' => ['required', 'string', 'max:100', 'unique:permohonan_pkb,npp'],
            'kode_badan_usaha' => ['required', 'string', 'max:100'],
            'bidang_usaha' => ['required', 'string', 'max:255'],
            'upah_min' => ['required', 'integer', 'min:0'],
            'upah_max' => ['required', 'integer', 'min:0'],
            'file_naskah_pkb' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $filePkb = $request->hasFile('file_naskah_pkb') ? $request->file('file_naskah_pkb')->store('uploads/hi', 'public') : null;

        PermohonanPkb::create([
            'company_id' => $company->id_company,
            'tahun_company' => $data['tahun_company'],
            'npp' => $data['npp'],
            'kode_badan_usaha' => $data['kode_badan_usaha'],
            'bidang_usaha' => $data['bidang_usaha'],
            'upah_min' => $data['upah_min'],
            'upah_max' => $data['upah_max'],
            'file_naskah_pkb' => $filePkb,
            'process_status' => SidutaConstants::HI_SUBMITTED,
            'created_by' => $company->id_company,
            'updated_by' => $company->id_company,
        ]);

        return back()->with('notyf_success', 'Permohonan pendaftaran PKB berhasil diajukan.');
    }
}
