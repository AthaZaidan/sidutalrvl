<?php

namespace App\Http\Controllers\Lpk;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Disability;
use App\Models\Training;
use App\Models\TrainingApplicant;
use App\Models\UserTrained;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index()
    {
        $lpk = Auth::guard('lpk')->user();
        $trainings = Training::with('city')
            ->withCount('applicants')
            ->where('lpk_id', $lpk->id_lpk)
            ->where('deleted_training', '0')
            ->orderByDesc('id_training')
            ->paginate(10);

        return view('lpk.trainings.index', compact('lpk', 'trainings'));
    }

    public function create()
    {
        return view('lpk.trainings.form', [
            'training' => null,
            'cities' => City::orderBy('city_name')->get(),
            'disabilities' => Disability::where('deleted_disability', '0')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $lpk = Auth::guard('lpk')->user();
        $data = $request->validate([
            'title_training' => ['required', 'string', 'max:256'],
            'city_training' => ['required', 'integer'],
            'price_training' => ['nullable', 'string', 'max:22'],
            'method_training' => ['required', 'integer'],
            'duration_training' => ['required', 'integer', 'min:1'],
            'date_training' => ['required', 'date'],
            'deadline_training' => ['nullable', 'date'],
            'place_training' => ['nullable', 'string', 'max:128'],
            'desc_training' => ['required', 'string'],
            'disability_status' => ['nullable', 'in:0,1'],
            'disabilities' => ['nullable', 'array'],
        ]);

        $tr = Training::create([
            'title_training' => $data['title_training'],
            'city_training' => $data['city_training'],
            'price_training' => $data['price_training'] ?? '0',
            'method_training' => $data['method_training'],
            'gender_training' => 0,
            'minage_training' => '17',
            'maxage_training' => '45',
            'duration_training' => $data['duration_training'],
            'date_training' => $data['date_training'],
            'deadline_training' => $data['deadline_training'] ?? null,
            'place_training' => $data['place_training'] ?? $lpk->address_lpk,
            'desc_training' => $data['desc_training'],
            'disability_status' => (int) ($data['disability_status'] ?? 0),
            'certificate_status' => 1,
            'publish_status' => SidutaConstants::SUBMITTED,
            'process_status' => SidutaConstants::PROC_SUBMITTED,
            'lpk_id' => $lpk->id_lpk,
            'deleted_training' => '0',
        ]);

        foreach ($data['disabilities'] ?? [] as $did) {
            DB::table('training_listdisability')->insert(['training_id' => $tr->id_training, 'disability_id' => (int) $did]);
        }

        $this->notifier->notifyAdmin(
            'Pengajuan Pelatihan baru dari ' . $lpk->name_lpk . ': ' . $tr->title_training,
            12,
            ['lpk_id' => $lpk->id_lpk, 'train_id' => $tr->id_training]
        );

        return redirect()->route('lpk.training.index')->with('notyf_success', 'Pelatihan berhasil diajukan untuk verifikasi.');
    }

    public function applicants(int $id)
    {
        $lpk = Auth::guard('lpk')->user();
        $training = Training::where('id_training', $id)->where('lpk_id', $lpk->id_lpk)->firstOrFail();
        $applicants = TrainingApplicant::with('user.educationLevel')->where('training_id', $id)->get();

        return view('lpk.trainings.applicants', compact('training', 'applicants'));
    }

    public function closeTraining(Request $request, int $id)
    {
        $lpk = Auth::guard('lpk')->user();
        $training = Training::where('id_training', $id)->where('lpk_id', $lpk->id_lpk)->firstOrFail();

        $graduatedIds = array_map('intval', (array) $request->input('graduated', []));
        $applicants = TrainingApplicant::where('training_id', $id)->get();

        foreach ($applicants as $app) {
            $grad = in_array((int) $app->user_id, $graduatedIds, true) ? 1 : 0;
            $app->update(['is_graduated' => $grad, 'process_apply' => SidutaConstants::APPLY_ACCEPTED]);

            UserTrained::updateOrCreate(
                ['user_id' => $app->user_id, 'training_id' => $id],
                ['is_graduated' => $grad]
            );
        }

        $training->update(['publish_status' => SidutaConstants::CLOSED]);
        return back()->with('notyf_success', 'Pelatihan ditutup & status kelulusan peserta disimpan.');
    }
}
