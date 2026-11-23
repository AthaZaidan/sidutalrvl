<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ak1;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Ak1ManagementController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index()
    {
        $ak1s = Ak1::with(['user', 'desiredJob.city'])
            ->where('deleted_ak1', 0)
            ->orderByDesc('id_ak1')
            ->paginate(15);

        return view('admin.management.ak1.index', ['activeMenu' => 'Management', 'ak1s' => $ak1s]);
    }

    public function show(int $id)
    {
        $ak1 = Ak1::with(['user.jobField', 'user.subJobField', 'user.educationLevel', 'user.skills', 'user.experiences', 'desiredJob.city', 'approver'])
            ->where('id_ak1', $id)
            ->firstOrFail();

        return view('admin.management.ak1.detail', ['activeMenu' => 'Management', 'ak1' => $ak1]);
    }

    public function validateAk1(int $id)
    {
        $ak1 = Ak1::findOrFail($id);
        $user = Auth::guard('web')->user();
        $roleId = (int) $user->role_id;

        if ($roleId === SidutaConstants::ADMIN_PENTA || ($roleId === SidutaConstants::SUPER_ADMIN && (int) $ak1->process_status === SidutaConstants::AK1_SUBMITTED)) {
            $ak1->update([
                'process_status' => SidutaConstants::AK1_ACCEPTED_PENTA,
                'approved_by' => $user->id,
                'updated_at' => now(),
            ]);
            $this->notifier->notifyAdmin('Admin Penta meneruskan pengajuan AK-1 #' . $ak1->id_ak1 . ' kepada Pengantar Kerja.', 24, ['ak1_id' => $ak1->id_ak1]);
        } elseif (in_array($roleId, [SidutaConstants::PENGANTAR_KERJA, SidutaConstants::SUPER_ADMIN], true)) {
            $ak1->update([
                'process_status' => SidutaConstants::AK1_APPROVED,
                'approved_by' => $user->id,
                'updated_at' => now(),
            ]);
            $this->notifier->notifyClient('Pembuatan AK-1 Anda telah disetujui dan siap dicetak.', $ak1->user_id);
            $this->notifier->notifyAdmin('Pengantar Kerja telah menyetujui AK-1 #' . $ak1->id_ak1, 26, ['ak1_id' => $ak1->id_ak1]);
        }

        return back()->with('flash_success', 'Berhasil memproses pengajuan AK-1.');
    }

    public function decline(Request $request, int $id)
    {
        $ak1 = Ak1::findOrFail($id);
        $data = $request->validate(['notes_penolakan' => ['required', 'string', 'max:255']]);
        $ak1->update([
            'process_status' => SidutaConstants::AK1_DECLINED_PENTA,
            'decline_reason' => $data['notes_penolakan'],
            'updated_at' => now(),
        ]);
        $this->notifier->notifyClient('Pengajuan AK-1 Anda tidak disetujui: ' . $data['notes_penolakan'], $ak1->user_id);

        return back()->with('flash_success', 'Pengajuan AK-1 ditolak.');
    }

    public function cetak(int $id)
    {
        $ak1 = Ak1::with(['user.jobField', 'user.subJobField', 'user.educationLevel', 'user.skills', 'desiredJob.city', 'approver'])
            ->findOrFail($id);
        $user = $ak1->user;

        $qrText = (int) $ak1->process_status === SidutaConstants::AK1_APPROVED
            ? 'SIDUTA AK-1 DISNAKER MEDAN | Pemilik: ' . $user->full_name . ' | Disetujui Oleh: ' . ($ak1->approver?->full_name ?? 'Pengantar Kerja')
            : 'Permohonan AK-1 Belum Disetujui';

        $qrcodeSvg = (new QRCode(new QROptions([
            'outputInterface' => QRMarkupSVG::class,
            'eccLevel' => EccLevel::L,
            'outputBase64' => false,
        ])))->render($qrText);
        return view('jobseeker.ak1.cetak', compact('user', 'ak1', 'qrcodeSvg'));
    }
}
