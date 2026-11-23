<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\DisputeCategory;
use App\Models\DisputeLog;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisputeController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index(Request $request)
    {
        $categories = DisputeCategory::where('deleted', 0)->get();
        $trackedDisputes = collect();

        if ($request->filled('nik')) {
            $nik = trim((string) $request->query('nik'));
            $trackedDisputes = Dispute::with('logs')
                ->where('deleted', 0)
                ->where('nik', $nik)
                ->orderByDesc('id')
                ->get();
        } elseif (Auth::guard('web')->check()) {
            $trackedDisputes = Dispute::with('logs')
                ->where('deleted', 0)
                ->where('user_created', Auth::guard('web')->id())
                ->orderByDesc('id')
                ->get();
        }

        return view('public.disputes.index', compact('categories', 'trackedDisputes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:256'],
            'nama' => ['required', 'string', 'max:100'],
            'nik' => ['required', 'string', 'max:16'],
            'email' => ['required', 'email', 'max:100'],
            'hp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'company' => ['required', 'string', 'max:100'],
            'address_company' => ['nullable', 'string'],
            'evidence' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:5120'],
        ]);

        $evidencePath = '';
        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')->store('uploads/evidence', 'public');
        }

        $dispute = Dispute::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'evidence' => $evidencePath,
            'status' => SidutaConstants::DISPUTE_SEND_BY_USER,
            'deleted' => 0,
            'user_created' => Auth::guard('web')->id() ?? 0,
            'nama' => $data['nama'],
            'nik' => $data['nik'],
            'email' => $data['email'],
            'hp' => $data['hp'],
            'alamat' => $data['alamat'],
            'company' => $data['company'],
            'address_company' => $data['address_company'] ?? '',
        ]);

        DisputeLog::create([
            'id_dispute' => $dispute->id,
            'action' => 'Pengaduan perselisihan hubungan kerja dikirim oleh ' . $data['nama'],
        ]);

        $this->notifier->notifyAdmin(
            'Pengaduan Perselisihan baru: ' . $data['title'] . ' (' . $data['nama'] . ')',
            31,
            ['dispute_id' => $dispute->id]
        );

        return redirect()->route('main.dispute.index', ['nik' => $data['nik']])
            ->with('notyf_success', 'Pengaduan perselisihan hubungan kerja berhasil dikirim.');
    }
}
