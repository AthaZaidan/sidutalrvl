<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use App\Models\JobField;
use App\Models\User;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;

class FindJobseekerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['jobField', 'educationLevel', 'skills'])
            ->where('role_id', SidutaConstants::ANGKATAN_KERJA)
            ->where('is_active', 1)
            ->where('deleted_user', '0')
            ->where('reg_status', SidutaConstants::STATUS_REG_JSDONE);

        if ($request->filled('keyword')) {
            $kw = trim((string) $request->query('keyword'));
            $query->where(function ($q) use ($kw) {
                $q->where('first_name', 'like', "%{$kw}%")
                    ->orWhere('last_name', 'like', "%{$kw}%")
                    ->orWhere('major', 'like', "%{$kw}%");
            });
        }
        if ($request->filled('job_field')) {
            $query->where('job_field', (int) $request->query('job_field'));
        }
        if ($request->filled('education_level')) {
            $query->where('education_level', (int) $request->query('education_level'));
        }

        $jobseekers = $query->orderByDesc('id')->paginate(12)->withQueryString();
        $jobFields = JobField::where('deleted_jobfield', '0')->get();
        $educationLevels = EducationLevel::where('deleted_educationlevel', '0')->get();

        return view('company.find-jobseekers.index', compact('jobseekers', 'jobFields', 'educationLevels'));
    }

    public function show(int $id)
    {
        $jobseeker = User::with(['jobField', 'subJobField', 'educationLevel', 'skills', 'experiences', 'languages'])
            ->where('role_id', SidutaConstants::ANGKATAN_KERJA)
            ->where('id', $id)
            ->firstOrFail();

        return view('company.find-jobseekers.show', compact('jobseeker'));
    }
}
