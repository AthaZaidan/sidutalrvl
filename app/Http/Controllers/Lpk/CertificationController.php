<?php

namespace App\Http\Controllers\Lpk;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\CertificationParticipant;
use App\Models\User;
use App\Models\Vocational;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificationController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index()
    {
        $lpk = Auth::guard('lpk')->user();
        $certifications = Certification::with('vocational')
            ->withCount('participants')
            ->where('lpk_id', $lpk->id_lpk)
            ->where('deleted_certification', 0)
            ->orderByDesc('id_certification')
            ->get();
        $vocationals = Vocational::where('deleted_vocational', '0')->get();
        $jobseekers = User::where('role_id', SidutaConstants::ANGKATAN_KERJA)->where('is_active', 1)->limit(100)->get();

        return view('lpk.certifications.index', compact('lpk', 'certifications', 'vocationals', 'jobseekers'));
    }

    public function store(Request $request)
    {
        $lpk = Auth::guard('lpk')->user();
        $data = $request->validate([
            'name_certification' => ['required', 'string', 'max:255'],
            'vocational_id' => ['required', 'integer'],
            'totalh_certification' => ['required', 'integer', 'min:1'],
            'date_certification' => ['required', 'date'],
            'loc_certification' => ['required', 'string', 'max:255'],
            'participant_ids' => ['nullable', 'array'],
        ]);

        $cert = Certification::create([
            'lpk_id' => $lpk->id_lpk,
            'name_certification' => $data['name_certification'],
            'vocational_id' => $data['vocational_id'],
            'totalh_certification' => $data['totalh_certification'],
            'date_certification' => $data['date_certification'],
            'loc_certification' => $data['loc_certification'],
            'totaluser_certification' => count($data['participant_ids'] ?? []),
            'process_status' => SidutaConstants::SUBMITTED_CER,
            'deleted_certification' => 0,
        ]);

        foreach ($data['participant_ids'] ?? [] as $uid) {
            CertificationParticipant::create([
                'certification_id' => $cert->id_certification,
                'user_id' => (int) $uid,
                'deleted_lc' => 0,
            ]);
        }

        $this->notifier->notifyAdmin(
            'Pengajuan Sertifikasi baru dari ' . $lpk->name_lpk . ': ' . $cert->name_certification,
            18,
            ['lpk_id' => $lpk->id_lpk, 'cf_id' => $cert->id_certification]
        );

        return back()->with('notyf_success', 'Pengajuan sertifikasi berhasil dikirim.');
    }
}
