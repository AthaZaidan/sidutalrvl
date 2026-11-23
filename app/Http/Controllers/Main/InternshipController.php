<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Internship;
use App\Models\InternshipApplicant;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index(Request $request)
    {
        $query = Internship::with(['company.badanUsaha', 'lpk', 'city', 'educationLevel'])
            ->where('deleted_intern', '0')
            ->where('publish_status', SidutaConstants::PUBLISHED);

        if ($request->filled('keyword')) {
            $kw = trim((string) $request->query('keyword'));
            $query->where('title_intern', 'like', "%{$kw}%");
        }
        if ($request->filled('city')) {
            $query->where('city_intern', (int) $request->query('city'));
        }

        $internships = $query->orderByDesc('id_intern')->paginate(10)->withQueryString();
        $cities = City::orderBy('city_name')->get();

        return view('public.internships.index', compact('internships', 'cities'));
    }

    public function detail(int $id)
    {
        $internship = Internship::with(['company.badanUsaha', 'lpk', 'city', 'educationLevel', 'skills'])
            ->where('deleted_intern', '0')
            ->where('id_intern', $id)
            ->firstOrFail();

        $user = Auth::guard('web')->user();
        $hasApplied = $user && (int) $user->role_id === SidutaConstants::ANGKATAN_KERJA
            ? InternshipApplicant::where('intern_id', $id)->where('user_id', $user->id)->exists()
            : false;

        return view('public.internships.show', compact('internship', 'hasApplied'));
    }

    public function apply(int $id)
    {
        $user = Auth::guard('web')->user();
        if (!$user || (int) $user->role_id !== SidutaConstants::ANGKATAN_KERJA) {
            return redirect()->route('jobseeker.login')->with('notyf_error', 'Silakan masuk sebagai Pencari Kerja terlebih dahulu.');
        }

        $internship = Internship::where('id_intern', $id)->where('deleted_intern', '0')->firstOrFail();

        if (InternshipApplicant::where('intern_id', $id)->where('user_id', $user->id)->exists()) {
            return redirect()->route('main.internship.detail', $id)->with('notyf_error', 'Anda sudah mendaftar program magang ini.');
        }

        InternshipApplicant::create([
            'intern_id' => $id,
            'user_id' => $user->id,
            'process_apply' => SidutaConstants::APPLY_PENDING,
        ]);

        $this->notifier->notifyClient(
            $user->full_name . ' mendaftar program magang ' . $internship->title_intern,
            null,
            $internship->company_id,
            $internship->lpk_id,
            null,
            $id
        );
        $this->notifier->notifyClient(
            'Pendaftaran magang ' . $internship->title_intern . ' berhasil dikirim.',
            $user->id,
            null,
            null,
            null,
            $id
        );

        return redirect()->route('main.internship.detail', $id)->with('notyf_success', 'Berhasil mendaftar program magang.');
    }
}
