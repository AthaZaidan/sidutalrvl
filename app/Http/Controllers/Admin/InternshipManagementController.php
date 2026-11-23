<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipManagementController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $query = Internship::with(['company.badanUsaha', 'lpk', 'city'])->withCount('applicants')->where('deleted_intern', '0');

        if ($status === 'pending') {
            $query->where('publish_status', SidutaConstants::SUBMITTED);
        } elseif ($status === 'published') {
            $query->where('publish_status', SidutaConstants::PUBLISHED);
        } elseif ($status === 'declined') {
            $query->where('publish_status', SidutaConstants::DECLINED);
        }

        $internships = $query->orderByDesc('id_intern')->paginate(15)->withQueryString();
        return view('admin.management.internships.index', ['activeMenu' => 'Management', 'internships' => $internships, 'status' => $status]);
    }

    public function approve(int $id)
    {
        $in = Internship::findOrFail($id);
        $user = Auth::guard('web')->user();

        if ((int) $user->role_id === SidutaConstants::INSTRUKTUR_PRODUKTIVITAS) {
            $in->update(['process_status' => SidutaConstants::PROC_REVIEWED_OFFICER, 'ip_id' => $user->id]);
        } else {
            $in->update(['process_status' => SidutaConstants::PROC_APPROVED_KABID, 'publish_status' => SidutaConstants::PUBLISHED]);
            $this->notifier->notifyClient('Program magang "' . $in->title_intern . '" telah diterbitkan.', null, $in->company_id, $in->lpk_id, null, $in->id_intern);
        }

        return back()->with('flash_success', 'Program magang berhasil diproses.');
    }

    public function decline(Request $request, int $id)
    {
        $in = Internship::findOrFail($id);
        $data = $request->validate(['reason' => ['required', 'string']]);
        $in->update(['publish_status' => SidutaConstants::DECLINED, 'process_status' => SidutaConstants::PROC_DECLINED, 'decline_reason' => $data['reason']]);
        return back()->with('flash_success', 'Program magang ditolak.');
    }
}
