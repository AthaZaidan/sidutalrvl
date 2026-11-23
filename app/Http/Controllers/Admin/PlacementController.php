<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportTkdn;
use App\Models\Tka;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
    public function index()
    {
        $tkdn = ReportTkdn::orderByDesc('id')->paginate(15, ['*'], 'tkdn_page');
        $tka = Tka::orderByDesc('id')->paginate(15, ['*'], 'tka_page');

        return view('admin.management.placements.index', [
            'activeMenu' => 'Management',
            'tkdn' => $tkdn,
            'tka' => $tka,
        ]);
    }

    public function storeTkdn(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:16'],
            'jabatan' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:4'],
        ]);
        ReportTkdn::create(array_merge($data, ['is_processed' => 1]));
        return back()->with('flash_success', 'Data penempatan TKDN ditambahkan.');
    }

    public function storeTka(Request $request)
    {
        $data = $request->validate([
            'name_cpmi' => ['required', 'string', 'max:255'],
            'nik' => ['nullable', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'country_of_destination' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:4'],
        ]);
        Tka::create(array_merge($data, ['created_at' => now()]));
        return back()->with('flash_success', 'Data penempatan CPMI/TKA ditambahkan.');
    }
}
