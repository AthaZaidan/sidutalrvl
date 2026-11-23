<?php

namespace App\Http\Controllers\Lpk;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\Internship;
use App\Models\SectorPotential;
use App\Models\Training;
use App\Models\Vocational;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $lpk = Auth::guard('lpk')->user()->load(['sectorPotential', 'vocationals']);
        $stats = [
            'trainings' => Training::where('lpk_id', $lpk->id_lpk)->where('deleted_training', '0')->count(),
            'internships' => Internship::where('lpk_id', $lpk->id_lpk)->where('deleted_intern', '0')->count(),
            'certifications' => Certification::where('lpk_id', $lpk->id_lpk)->where('deleted_certification', 0)->count(),
        ];

        return view('lpk.dashboard', compact('lpk', 'stats'));
    }

    public function profile()
    {
        $lpk = Auth::guard('lpk')->user()->load('vocationals');
        $sectors = SectorPotential::where('deleted_sector', '0')->get();
        $vocationals = Vocational::where('deleted_vocational', '0')->get();

        return view('lpk.profile', compact('lpk', 'sectors', 'vocationals'));
    }

    public function updateProfile(Request $request)
    {
        $lpk = Auth::guard('lpk')->user();
        $data = $request->validate([
            'name_lpk' => ['required', 'string', 'max:128'],
            'name_leader' => ['required', 'string', 'max:128'],
            'address_lpk' => ['required', 'string', 'max:128'],
            'no_telp' => ['required', 'string', 'max:128'],
            'nohp_pimpinan' => ['required', 'string', 'max:128'],
            'daya_tampung_lpk' => ['nullable', 'integer'],
            'count_staff' => ['nullable', 'integer'],
            'vocationals' => ['nullable', 'array'],
        ]);

        $lpk->update(collect($data)->except('vocationals')->toArray());

        if ($request->has('vocationals')) {
            DB::table('lpk_listvocational')->where('lpk_id', $lpk->id_lpk)->delete();
            foreach ($data['vocationals'] ?? [] as $vid) {
                DB::table('lpk_listvocational')->insert(['lpk_id' => $lpk->id_lpk, 'vocational_id' => (int) $vid]);
            }
        }

        return back()->with('notyf_success', 'Profil LPK diperbarui.');
    }
}
