<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\BadanUsaha;
use App\Models\CompanyCategory;
use App\Models\Internship;
use App\Models\JobVacancy;
use App\Models\Karyawan;
use App\Models\PermohonanPkb;
use App\Models\PermohonanPkwt;
use App\Models\PermohonanPp;
use App\Models\Wlkp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $company = Auth::guard('company')->user()->load(['badanUsaha', 'category']);
        $stats = [
            'jobs' => JobVacancy::where('company_id', $company->id_company)->where('deleted_vacancy', '0')->count(),
            'internships' => Internship::where('company_id', $company->id_company)->where('deleted_intern', '0')->count(),
            'karyawan' => Karyawan::where('company_id', $company->id_company)->where('is_active', 1)->count(),
            'wlkp' => Wlkp::where('company_id', $company->id_company)->count(),
            'hi_requests' => PermohonanPp::where('company_id', $company->id_company)->where('is_deleted', 0)->count()
                + PermohonanPkwt::where('company_id', $company->id_company)->where('is_deleted', 0)->count()
                + PermohonanPkb::where('company_id', $company->id_company)->where('is_deleted', 0)->count(),
        ];

        return view('company.dashboard', compact('company', 'stats'));
    }

    public function profile()
    {
        $company = Auth::guard('company')->user()->load(['badanUsaha', 'category']);
        $badanUsaha = BadanUsaha::where('deleted_badanusaha', '0')->get();
        $categories = CompanyCategory::where('deleted_category', '0')->get();

        return view('company.profile', compact('company', 'badanUsaha', 'categories'));
    }

    public function updateProfile(Request $request)
    {
        $company = Auth::guard('company')->user();
        $data = $request->validate([
            'name_company' => ['required', 'string', 'max:256'],
            'address_company' => ['required', 'string', 'max:256'],
            'hp_company' => ['required', 'string', 'max:128'],
            'pj_company' => ['required', 'string', 'max:128'],
            'cp_penanggungjawab' => ['required', 'string', 'max:128'],
            'name_direktur' => ['nullable', 'string', 'max:255'],
            'jabatan_pj' => ['nullable', 'string', 'max:255'],
            'npwp_company' => ['nullable', 'string', 'max:128'],
            'nib_company' => ['nullable', 'string', 'max:128'],
            'badanusaha_company' => ['nullable', 'integer'],
            'category_company' => ['nullable', 'integer'],
        ]);

        $company->update($data);
        return back()->with('notyf_success', 'Profil perusahaan diperbarui.');
    }
}
