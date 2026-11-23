<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\Ak1;
use App\Models\City;
use App\Models\UserDesiredJob;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Ak1Controller extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index()
    {
        $user = Auth::guard('web')->user();
        $ak1List = Ak1::with(['desiredJob.city', 'approver'])
            ->where('user_id', $user->id)
            ->where('deleted_ak1', 0)
            ->orderByDesc('id_ak1')
            ->get();
        $cities = City::orderBy('city_name')->get();

        return view('jobseeker.ak1.index', compact('user', 'ak1List', 'cities'));
    }

    public function store(Request $request)
    {
        $user = Auth::guard('web')->user();

        $activeAk1 = Ak1::where('user_id', $user->id)
            ->where('deleted_ak1', 0)
            ->whereIn('process_status', [SidutaConstants::AK1_SUBMITTED, SidutaConstants::AK1_ACCEPTED_PENTA])
            ->exists();

        if ($activeAk1) {
            return back()->with('notyf_error', 'Anda masih memiliki pengajuan AK-1 yang sedang diproses.');
        }

        $data = $request->validate([
            'position' => ['required', 'string', 'max:256'],
            'sallary' => ['required', 'string', 'max:256'],
            'placement' => ['required', 'string', 'max:256'],
            'location' => ['required', 'string', 'max:256'],
            'nation' => ['nullable', 'string', 'max:15'],
        ]);

        $ak1 = Ak1::create([
            'user_id' => $user->id,
            'process_status' => SidutaConstants::AK1_SUBMITTED,
            'deleted_ak1' => 0,
        ]);

        UserDesiredJob::create([
            'id_user' => $user->id,
            'id_ak1' => $ak1->id_ak1,
            'position' => $data['position'],
            'sallary' => $data['sallary'],
            'placement' => $data['placement'],
            'location' => $data['location'],
            'nation' => $data['nation'] ?? 'Indonesia',
            'deleted' => 0,
        ]);

        $this->notifier->notifyAdmin(
            'Pengajuan AK-1 baru dari ' . $user->full_name,
            15,
            ['user_id' => $user->id, 'ak1_id' => $ak1->id_ak1]
        );

        return redirect()->route('jobseeker.ak1.index')->with('notyf_success', 'Pengajuan Kartu AK-1 berhasil dikirim.');
    }

    public function cetak(int $id)
    {
        $user = Auth::guard('web')->user()->load(['jobField', 'subJobField', 'educationLevel', 'skills']);
        $ak1 = Ak1::with(['desiredJob.city', 'approver'])
            ->where('id_ak1', $id)
            ->where('user_id', $user->id)
            ->where('deleted_ak1', 0)
            ->firstOrFail();

        $qrText = (int) $ak1->process_status === SidutaConstants::AK1_APPROVED
            ? 'SIDUTA AK-1 DISNAKER MEDAN | Pemilik: ' . $user->full_name . ' | NIK: ' . $user->nik . ' | Disetujui: ' . ($ak1->updated_at ?? now()) . ' | Oleh: ' . ($ak1->approver?->full_name ?? 'Pengantar Kerja')
            : 'Permohonan AK-1 Belum Disetujui';

        $options = new QROptions([
            'outputInterface' => QRMarkupSVG::class,
            'eccLevel' => EccLevel::L,
            'outputBase64' => false,
            'addQuietzone' => true,
        ]);
        $qrcodeSvg = (new QRCode($options))->render($qrText);

        return view('jobseeker.ak1.cetak', compact('user', 'ak1', 'qrcodeSvg'));
    }
}
