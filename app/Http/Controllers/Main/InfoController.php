<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\CertificationParticipant;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function jdih()
    {
        return view('public.jdih');
    }

    public function certificate(Request $request)
    {
        $code = trim((string) $request->query('code', ''));
        $record = null;

        if ($code !== '') {
            $record = CertificationParticipant::with(['certification.lpk', 'certification.vocational', 'user'])
                ->where('deleted_lc', 0)
                ->where('certification_code', $code)
                ->first();
        }

        return view('public.certificates.index', compact('code', 'record'));
    }

    public function downloadManual(string $type)
    {
        $map = [
            'jobseeker' => 'Panduan_Angkatan_Kerja.pdf',
            'company' => 'Panduan_Perusahaan.pdf',
            'lpk' => 'Panduan_LPK.pdf',
            'disnaker' => 'Panduan_Disnaker.pdf',
        ];

        $key = strtolower($type);
        $manualDir = public_path('assets/manual');
        if (is_dir($manualDir)) {
            $files = glob($manualDir . '/*.pdf');
            foreach ($files as $file) {
                if (stripos(basename($file), $key) !== false) {
                    return response()->download($file);
                }
            }
            if (!empty($files)) {
                return response()->download($files[0]);
            }
        }

        return back()->with('notyf_error', 'File panduan (' . ($map[$key] ?? $type) . ') belum tersedia.');
    }
}
