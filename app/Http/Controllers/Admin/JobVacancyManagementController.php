<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobVacancyManagementController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $query = JobVacancy::with(['company.badanUsaha', 'jobField', 'city'])
            ->withCount('applicants')
            ->where('deleted_vacancy', '0');

        if ($status === 'pending') {
            $query->where('publish_status', SidutaConstants::SUBMITTED)->where('process_status', SidutaConstants::PROC_SUBMITTED);
        } elseif ($status === 'process') {
            $query->where('publish_status', SidutaConstants::SUBMITTED)->where('process_status', SidutaConstants::PROC_REVIEWED_OFFICER);
        } elseif ($status === 'published') {
            $query->where('publish_status', SidutaConstants::PUBLISHED);
        } elseif ($status === 'declined') {
            $query->where('publish_status', SidutaConstants::DECLINED);
        } elseif ($status === 'closed') {
            $query->where('publish_status', SidutaConstants::CLOSED);
        }

        $vacancies = $query->orderByDesc('id_jobvacancy')->paginate(15)->withQueryString();
        return view('admin.management.job-vacancies.index', ['activeMenu' => 'Management', 'vacancies' => $vacancies, 'status' => $status]);
    }

    public function show(int $id)
    {
        $vacancy = JobVacancy::with(['company.badanUsaha', 'jobField', 'subJobField', 'city', 'skills', 'applicants.user'])
            ->where('id_jobvacancy', $id)
            ->firstOrFail();

        return view('admin.management.job-vacancies.detail', ['activeMenu' => 'Management', 'vacancy' => $vacancy]);
    }

    public function approve(Request $request, int $id)
    {
        $jv = JobVacancy::findOrFail($id);
        $user = Auth::guard('web')->user();
        $roleId = (int) $user->role_id;

        if ($roleId === SidutaConstants::PENGANTAR_KERJA) {
            $jv->update(['process_status' => SidutaConstants::PROC_REVIEWED_OFFICER, 'pk_id' => $user->id]);
            $this->notifier->notifyAdmin('Lowongan kerja diteruskan Pengantar Kerja ke KABID PENTA: ' . $jv->title_jobvacancy, 15, ['jv_id' => $jv->id_jobvacancy]);
        } else {
            $jv->update([
                'process_status' => SidutaConstants::PROC_APPROVED_KABID,
                'publish_status' => SidutaConstants::PUBLISHED,
                'publish_date' => now(),
                'pk_id' => $jv->pk_id ?? $user->id,
            ]);
            $this->notifier->notifyClient('Lowongan kerja Anda "' . $jv->title_jobvacancy . '" telah disetujui dan diterbitkan.', null, $jv->company_id, null, $jv->id_jobvacancy);
        }

        return back()->with('flash_success', 'Lowongan kerja berhasil diproses.');
    }

    public function decline(Request $request, int $id)
    {
        $jv = JobVacancy::findOrFail($id);
        $data = $request->validate(['reason' => ['required', 'string']]);
        $jv->update([
            'publish_status' => SidutaConstants::DECLINED,
            'process_status' => SidutaConstants::PROC_DECLINED,
            'decline_reason' => $data['reason'],
        ]);
        $this->notifier->notifyClient('Lowongan kerja "' . $jv->title_jobvacancy . '" ditolak: ' . $data['reason'], null, $jv->company_id, null, $jv->id_jobvacancy);

        return back()->with('flash_success', 'Lowongan kerja ditolak.');
    }
}
