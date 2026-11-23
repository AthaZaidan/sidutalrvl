<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ak1;
use App\Models\Company;
use App\Models\Dispute;
use App\Models\Internship;
use App\Models\JobVacancy;
use App\Models\Lpk;
use App\Models\PermohonanPkb;
use App\Models\PermohonanPkwt;
use App\Models\PermohonanPp;
use App\Models\SurveyRespondenProfile;
use App\Models\Training;
use App\Models\User;
use App\Models\Visitor;
use App\Support\SidutaConstants;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'jobseekers' => User::where('role_id', SidutaConstants::ANGKATAN_KERJA)->where('deleted_user', '0')->count(),
            'companies' => Company::where('deleted_company', '0')->count(),
            'lpks' => Lpk::where('deleted_lpk', '0')->count(),
            'job_vacancies' => JobVacancy::where('deleted_vacancy', '0')->count(),
            'internships' => Internship::where('deleted_intern', '0')->count(),
            'trainings' => Training::where('deleted_training', '0')->count(),
            'ak1' => Ak1::where('deleted_ak1', 0)->count(),
            'disputes' => Dispute::where('deleted', 0)->count(),
            'hi_services' => PermohonanPp::where('is_deleted', 0)->count()
                + PermohonanPkwt::where('is_deleted', 0)->count()
                + PermohonanPkb::where('is_deleted', 0)->count(),
            'survey_respondents' => SurveyRespondenProfile::count(),
            'visitors_today' => Visitor::where('date', now()->toDateString())->sum('hits'),
        ];

        return view('admin.dashboard', [
            'activeMenu' => 'Administrator',
            'stats' => $stats,
        ]);
    }
}
