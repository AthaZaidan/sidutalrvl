<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Training;
use App\Models\TrainingApplicant;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index(Request $request)
    {
        $query = Training::with(['lpk', 'city'])
            ->where('deleted_training', '0')
            ->where('publish_status', SidutaConstants::PUBLISHED);

        if ($request->filled('keyword')) {
            $kw = trim((string) $request->query('keyword'));
            $query->where('title_training', 'like', "%{$kw}%");
        }
        if ($request->filled('city')) {
            $query->where('city_training', (int) $request->query('city'));
        }
        if ($request->boolean('disability')) {
            $query->where('disability_status', 1);
        }

        $trainings = $query->orderByDesc('id_training')->paginate(10)->withQueryString();
        $cities = City::orderBy('city_name')->get();

        return view('public.trainings.index', compact('trainings', 'cities'));
    }

    public function detail(int $id)
    {
        $training = Training::with(['lpk', 'city', 'disabilities'])
            ->where('deleted_training', '0')
            ->where('id_training', $id)
            ->firstOrFail();

        $user = Auth::guard('web')->user();
        $hasApplied = $user && (int) $user->role_id === SidutaConstants::ANGKATAN_KERJA
            ? TrainingApplicant::where('training_id', $id)->where('user_id', $user->id)->exists()
            : false;

        return view('public.trainings.show', compact('training', 'hasApplied'));
    }

    public function apply(int $id)
    {
        $user = Auth::guard('web')->user();
        if (!$user || (int) $user->role_id !== SidutaConstants::ANGKATAN_KERJA) {
            return redirect()->route('jobseeker.login')->with('notyf_error', 'Silakan masuk sebagai Pencari Kerja terlebih dahulu.');
        }

        $training = Training::where('id_training', $id)->where('deleted_training', '0')->firstOrFail();

        if (TrainingApplicant::where('training_id', $id)->where('user_id', $user->id)->exists()) {
            return redirect()->route('main.training.detail', $id)->with('notyf_error', 'Anda sudah mendaftar pelatihan ini.');
        }

        TrainingApplicant::create([
            'training_id' => $id,
            'user_id' => $user->id,
            'process_apply' => SidutaConstants::APPLY_PENDING,
        ]);

        $this->notifier->notifyClient(
            $user->full_name . ' mendaftar pelatihan ' . $training->title_training,
            null,
            null,
            $training->lpk_id,
            null,
            null,
            $id
        );
        $this->notifier->notifyClient(
            'Pendaftaran pelatihan ' . $training->title_training . ' telah terkirim.',
            $user->id,
            null,
            null,
            null,
            null,
            $id
        );

        return redirect()->route('main.training.detail', $id)->with('notyf_success', 'Berhasil mendaftar pelatihan.');
    }
}
