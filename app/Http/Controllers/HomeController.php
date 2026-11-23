<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Internship;
use App\Models\JobField;
use App\Models\JobVacancy;
use App\Models\School;
use App\Models\Skill;
use App\Models\SubJobField;
use App\Models\Training;
use App\Models\University;
use App\Models\Visitor;
use App\Support\SidutaConstants;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $today = now()->toDateString();
            $ip = (string) $request->ip();
            $visitor = Visitor::where('ip', $ip)->where('date', $today)->first();
            if ($visitor) {
                $visitor->increment('hits');
                $visitor->update(['time' => now()]);
            } else {
                Visitor::create([
                    'ip' => $ip,
                    'date' => $today,
                    'hits' => 1,
                    'online' => (string) time(),
                    'time' => now(),
                ]);
            }
        } catch (\Throwable) {
        }

        $categories = JobField::where('deleted_jobfield', '0')->orderBy('name_jobfield')->get();
        $latestJobs = JobVacancy::with(['company.badanUsaha', 'city', 'jobField'])
            ->where('deleted_vacancy', '0')
            ->where('publish_status', SidutaConstants::PUBLISHED)
            ->orderByDesc('id_jobvacancy')
            ->limit(6)
            ->get();

        $stats = [
            'jobs' => JobVacancy::where('deleted_vacancy', '0')->where('publish_status', SidutaConstants::PUBLISHED)->count(),
            'internships' => Internship::where('deleted_intern', '0')->where('publish_status', SidutaConstants::PUBLISHED)->count(),
            'trainings' => Training::where('deleted_training', '0')->where('publish_status', SidutaConstants::PUBLISHED)->count(),
        ];

        return view('public.home', [
            'styles' => 1,
            'categories' => $categories,
            'latestJobs' => $latestJobs,
            'stats' => $stats,
        ]);
    }

    public function subJobFields(Request $request)
    {
        $q = SubJobField::where('deleted_subjobfield', '0');
        if ($request->filled('job_field_id')) {
            $q->where('id_job_field', (int) $request->query('job_field_id'));
        }
        return response()->json($q->orderBy('name_subjobfield')->get());
    }

    public function skills(Request $request)
    {
        $term = trim((string) $request->query('q', ''));
        $q = Skill::where('deleted_skill', '0');
        if ($term !== '') {
            $q->where('name_skill', 'like', "%{$term}%");
        }
        return response()->json($q->orderBy('name_skill')->limit(50)->get());
    }

    public function schools(Request $request)
    {
        $eduLevel = (int) $request->query('education_level_id', 0);
        if ($eduLevel >= 5) {
            return response()->json(University::where('deleted_university', '0')->orderBy('name_university')->limit(100)->get());
        }
        $q = School::where('deleted_school', '0');
        if ($eduLevel > 0) {
            $q->where('education_level_id', $eduLevel);
        }
        return response()->json($q->orderBy('name_school')->limit(100)->get());
    }

    public function cities(Request $request)
    {
        $q = City::query();
        if ($request->filled('prov_id')) {
            $q->where('prov_id', (int) $request->query('prov_id'));
        }
        return response()->json($q->orderBy('city_name')->get());
    }
}
