<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\SurveyQuestion;
use App\Models\SurveyRespondenAnswer;
use App\Models\SurveyRespondenProfile;
use App\Models\SurveyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        $services = SurveyService::whereNull('deleted_at')->get();
        $questions = SurveyQuestion::whereNull('deleted_at')->where('is_active', 1)->orderBy('id')->get();
        $totalRespondents = SurveyRespondenProfile::count();
        $avgScore = SurveyRespondenAnswer::avg('persepsi_value');

        return view('public.surveys.index', compact('services', 'questions', 'totalRespondents', 'avgScore'));
    }

    public function store(Request $request)
    {
        $questions = SurveyQuestion::whereNull('deleted_at')->where('is_active', 1)->get();

        $rules = [
            'survey_service_id' => ['required', 'integer', 'exists:survey_services,id'],
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:15', 'max:99'],
            'gender' => ['required', 'string', 'max:50'],
            'education' => ['required', 'string', 'max:100'],
            'job' => ['required', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string', 'max:100'],
            'saran' => ['nullable', 'string'],
            'answers' => ['required', 'array'],
        ];

        $data = $request->validate($rules);

        DB::transaction(function () use ($data, $questions) {
            $profile = SurveyRespondenProfile::create([
                'survey_service_id' => $data['survey_service_id'],
                'name' => $data['name'],
                'age' => $data['age'],
                'gender' => $data['gender'],
                'education' => $data['education'],
                'job' => $data['job'],
                'no_hp' => $data['no_hp'] ?? null,
                'email' => $data['email'] ?? null,
                'address' => $data['address'] ?? null,
                'saran' => $data['saran'] ?? null,
            ]);

            foreach ($questions as $q) {
                $val = (int) ($data['answers'][$q->id] ?? 4);
                $val = max(1, min(4, $val));
                SurveyRespondenAnswer::create([
                    'responden_id' => $profile->id,
                    'question_id' => $q->id,
                    'persepsi_value' => $val,
                ]);
            }
        });

        return redirect()->route('main.survey.index')->with('notyf_success', 'Terima kasih! Partisipasi Survei Kepuasan Masyarakat Anda telah tersimpan.');
    }
}
