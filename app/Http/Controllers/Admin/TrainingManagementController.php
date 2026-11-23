<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingManagementController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $query = Training::with(['lpk', 'city'])->withCount('applicants')->where('deleted_training', '0');

        if ($status === 'pending') {
            $query->where('publish_status', SidutaConstants::SUBMITTED);
        } elseif ($status === 'published') {
            $query->where('publish_status', SidutaConstants::PUBLISHED);
        } elseif ($status === 'declined') {
            $query->where('publish_status', SidutaConstants::DECLINED);
        }

        $trainings = $query->orderByDesc('id_training')->paginate(15)->withQueryString();
        return view('admin.management.trainings.index', ['activeMenu' => 'Management', 'trainings' => $trainings, 'status' => $status]);
    }

    public function approve(int $id)
    {
        $tr = Training::findOrFail($id);
        $user = Auth::guard('web')->user();

        if ((int) $user->role_id === SidutaConstants::INSTRUKTUR_PELATIHAN) {
            $tr->update(['process_status' => SidutaConstants::PROC_REVIEWED_OFFICER, 'ipo_id' => $user->id]);
        } else {
            $tr->update(['process_status' => SidutaConstants::PROC_APPROVED_KABID, 'publish_status' => SidutaConstants::PUBLISHED]);
            $this->notifier->notifyClient('Pelatihan "' . $tr->title_training . '" telah disetujui dan diterbitkan.', null, null, $tr->lpk_id, null, null, $tr->id_training);
        }

        return back()->with('flash_success', 'Pelatihan berhasil diproses.');
    }

    public function decline(Request $request, int $id)
    {
        $tr = Training::findOrFail($id);
        $data = $request->validate(['reason' => ['required', 'string']]);
        $tr->update(['publish_status' => SidutaConstants::DECLINED, 'process_status' => SidutaConstants::PROC_DECLINED, 'decline_reason' => $data['reason']]);
        return back()->with('flash_success', 'Pelatihan ditolak.');
    }
}
