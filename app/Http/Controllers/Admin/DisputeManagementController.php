<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\DisputeLog;
use App\Models\User;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisputeManagementController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $query = Dispute::with('mediatorUser')->where('deleted', 0);

        if ($status === 'incoming') {
            $query->where('status', SidutaConstants::DISPUTE_SEND_BY_USER);
        } elseif ($status === 'processed') {
            $query->whereIn('status', [SidutaConstants::DISPUTE_ACCEPTED_ADMIN_PSP, SidutaConstants::DISPUTE_ACCEPTED_KABID]);
        } elseif ($status === 'cleared') {
            $query->where('status', SidutaConstants::DISPUTE_CLEARED_MEDIATOR);
        } elseif ($status === 'closed') {
            $query->whereIn('status', [SidutaConstants::DISPUTE_FINISHED_KABID, SidutaConstants::DISPUTE_UNSOLVED]);
        }

        $disputes = $query->orderByDesc('id')->paginate(15)->withQueryString();
        $mediators = User::where('role_id', SidutaConstants::MEDIATOR)->where('is_active', 1)->get();

        return view('admin.management.disputes.index', [
            'activeMenu' => 'Management',
            'disputes' => $disputes,
            'mediators' => $mediators,
            'status' => $status,
        ]);
    }

    public function show(int $id)
    {
        $dispute = Dispute::with(['mediatorUser', 'logs'])->findOrFail($id);
        $mediators = User::where('role_id', SidutaConstants::MEDIATOR)->where('is_active', 1)->get();

        return view('admin.management.disputes.show', [
            'activeMenu' => 'Management',
            'dispute' => $dispute,
            'mediators' => $mediators,
        ]);
    }

    public function process(Request $request, int $id)
    {
        $dispute = Dispute::findOrFail($id);
        $action = $request->input('action');
        $actor = Auth::guard('web')->user();

        if ($action === 'accept_psp') {
            $dispute->update(['status' => SidutaConstants::DISPUTE_ACCEPTED_ADMIN_PSP, 'updated_at' => now(), 'updated_by' => $actor->id]);
            DisputeLog::create(['id_dispute' => $dispute->id, 'action' => 'Diverifikasi Admin PSP dan diteruskan ke KABID HI/PSP.']);
            $this->notifier->notifyAdmin('Perselisihan diteruskan Admin PSP: ' . $dispute->title, 32, ['dispute_id' => $dispute->id]);
        } elseif ($action === 'assign_mediator') {
            $data = $request->validate(['mediator' => ['required', 'integer']]);
            $mediator = User::findOrFail($data['mediator']);
            $dispute->update([
                'status' => SidutaConstants::DISPUTE_ACCEPTED_KABID,
                'mediator' => $mediator->id,
                'updated_at' => now(),
                'updated_by' => $actor->id,
            ]);
            DisputeLog::create(['id_dispute' => $dispute->id, 'action' => 'KABID menunjuk Mediator: ' . $mediator->full_name]);
            $this->notifier->notifyAdmin('KABID menugaskan mediator ' . $mediator->full_name, 33, ['dispute_id' => $dispute->id]);
        } elseif ($action === 'solved' || $action === 'unsolved') {
            $data = $request->validate(['solving_description' => ['required', 'string', 'max:500']]);
            $newStatus = $action === 'solved' ? SidutaConstants::DISPUTE_CLEARED_MEDIATOR : SidutaConstants::DISPUTE_UNSOLVED;
            $dispute->update([
                'status' => $newStatus,
                'solving_description' => $data['solving_description'],
                'closed_date' => now(),
                'updated_at' => now(),
                'updated_by' => $actor->id,
            ]);
            DisputeLog::create(['id_dispute' => $dispute->id, 'action' => ($action === 'solved' ? 'Diselesaikan Mediator: ' : 'Tidak Selesai: ') . $data['solving_description']]);
        } elseif ($action === 'finish') {
            $dispute->update(['status' => SidutaConstants::DISPUTE_FINISHED_KABID, 'closed_date' => now(), 'updated_at' => now(), 'updated_by' => $actor->id]);
            DisputeLog::create(['id_dispute' => $dispute->id, 'action' => 'Perselisihan ditutup oleh KABID HI/PSP.']);
        }

        return back()->with('flash_success', 'Status perselisihan diperbarui.');
    }
}
