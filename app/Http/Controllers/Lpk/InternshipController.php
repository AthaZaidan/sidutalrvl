<?php

namespace App\Http\Controllers\Lpk;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\EducationLevel;
use App\Models\Internship;
use App\Models\InternshipApplicant;
use App\Models\JobField;
use App\Models\SubJobField;
use App\Services\NotificationService;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function __construct(private readonly NotificationService $notifier)
    {
    }

    public function index()
    {
        $lpk = Auth::guard('lpk')->user();
        $internships = Internship::with('city')
            ->withCount('applicants')
            ->where('lpk_id', $lpk->id_lpk)
            ->where('deleted_intern', '0')
            ->orderByDesc('id_intern')
            ->paginate(10);

        return view('lpk.internships.index', compact('lpk', 'internships'));
    }

    public function create()
    {
        return view('lpk.internships.form', [
            'jobFields' => JobField::where('deleted_jobfield', '0')->get(),
            'subJobFields' => SubJobField::where('deleted_subjobfield', '0')->get(),
            'cities' => City::orderBy('city_name')->get(),
            'educationLevels' => EducationLevel::where('deleted_educationlevel', '0')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $lpk = Auth::guard('lpk')->user();
        $data = $request->validate([
            'title_intern' => ['required', 'string', 'max:256'],
            'jobfield_intern' => ['required', 'string'],
            'subjobfield_intern' => ['required', 'integer'],
            'city_intern' => ['required', 'integer'],
            'length_intern' => ['required', 'integer', 'min:1'],
            'min_edu_level' => ['required', 'integer'],
            'desc_intern' => ['required', 'string'],
        ]);

        $intern = Internship::create([
            'title_intern' => $data['title_intern'],
            'jobfield_intern' => $data['jobfield_intern'],
            'subjobfield_intern' => $data['subjobfield_intern'],
            'city_intern' => $data['city_intern'],
            'length_intern' => $data['length_intern'],
            'duration_intern' => $data['length_intern'],
            'min_edu_level' => $data['min_edu_level'],
            'desc_intern' => $data['desc_intern'],
            'experience_intern' => 0,
            'publish_status' => SidutaConstants::SUBMITTED,
            'process_status' => SidutaConstants::PROC_SUBMITTED,
            'lpk_id' => $lpk->id_lpk,
            'ip_id' => 0,
            'deleted_intern' => '0',
        ]);

        $this->notifier->notifyAdmin(
            'Pengajuan Magang baru dari LPK ' . $lpk->name_lpk . ': ' . $intern->title_intern,
            10,
            ['lpk_id' => $lpk->id_lpk, 'in_id' => $intern->id_intern]
        );

        return redirect()->route('lpk.internship.index')->with('notyf_success', 'Program magang LPK diajukan.');
    }

    public function applicants(int $id)
    {
        $lpk = Auth::guard('lpk')->user();
        $internship = Internship::where('id_intern', $id)->where('lpk_id', $lpk->id_lpk)->firstOrFail();
        $applicants = InternshipApplicant::with('user')->where('intern_id', $id)->get();

        return view('lpk.internships.applicants', compact('internship', 'applicants'));
    }
}
