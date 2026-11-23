<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\CertificationParticipant;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificationManagementController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index()
    {
        $certifications = Certification::with(['lpk', 'vocational'])
            ->withCount('participants')
            ->where('deleted_certification', 0)
            ->orderByDesc('id_certification')
            ->paginate(15);

        return view('admin.management.certifications.index', ['activeMenu' => 'Management', 'certifications' => $certifications]);
    }

    public function show(int $id)
    {
        $certification = Certification::with(['lpk', 'vocational', 'participants.user'])->findOrFail($id);
        return view('admin.management.certifications.detail', ['activeMenu' => 'Management', 'certification' => $certification]);
    }

    public function advance(int $id)
    {
        $cert = Certification::with('participants')->findOrFail($id);
        $roleId = (int) Auth::guard('web')->user()->role_id;

        $nextStatus = match (true) {
            $cert->process_status == SidutaConstants::SUBMITTED_CER && in_array($roleId, [SidutaConstants::ADMIN_LATTAS, SidutaConstants::SUPER_ADMIN], true) => SidutaConstants::ACCEPTED_CER_BY_ADMINLATAS,
            $cert->process_status == SidutaConstants::ACCEPTED_CER_BY_ADMINLATAS && in_array($roleId, [SidutaConstants::INSTRUKTUR_SERTIFIKASI, SidutaConstants::SUPER_ADMIN], true) => SidutaConstants::ACCEPTED_CER_BY_INSCER,
            $cert->process_status == SidutaConstants::ACCEPTED_CER_BY_INSCER && in_array($roleId, [SidutaConstants::KABID_LATTAS, SidutaConstants::SUPER_ADMIN], true) => SidutaConstants::ACCEPTED_CER_BY_KABIDLATAS,
            $cert->process_status == SidutaConstants::ACCEPTED_CER_BY_KABIDLATAS && in_array($roleId, [SidutaConstants::KADIS, SidutaConstants::SUPER_ADMIN], true) => SidutaConstants::APPROVED_CER,
            default => $cert->process_status,
        };

        $cert->update(['process_status' => $nextStatus, 'updated_at' => now()]);

        if ($nextStatus === SidutaConstants::APPROVED_CER) {
            foreach ($cert->participants as $idx => $p) {
                if (empty($p->certification_code)) {
                    $p->update([
                        'certification_code' => 'SIDUTA-CERT-' . date('Y') . '-' . str_pad((string) $p->id_lc, 4, '0', STR_PAD_LEFT),
                    ]);
                }
            }
            $this->notifier->notifyClient('Pengajuan sertifikasi "' . $cert->name_certification . '" telah disetujui KADIS.', null, null, $cert->lpk_id);
        }

        return back()->with('flash_success', 'Tahap sertifikasi diperbarui.');
    }

    public function reject(Request $request, int $id)
    {
        $cert = Certification::findOrFail($id);
        $data = $request->validate(['reason' => ['required', 'string', 'max:255']]);
        $cert->update(['process_status' => SidutaConstants::REJECTED_CER, 'decline_reason' => $data['reason'], 'updated_at' => now()]);
        return back()->with('flash_success', 'Sertifikasi ditolak.');
    }
}
