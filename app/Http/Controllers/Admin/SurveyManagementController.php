<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SurveyQuestion;
use App\Models\SurveyRespondenAnswer;
use App\Models\SurveyRespondenProfile;
use App\Models\SurveyService;
use Illuminate\Http\Request;

class SurveyManagementController extends Controller
{
    public function index()
    {
        $services = SurveyService::whereNull('deleted_at')->get();
        $questions = SurveyQuestion::whereNull('deleted_at')->get();
        $respondents = SurveyRespondenProfile::with('service')->orderByDesc('id')->paginate(15);
        $avgScore = SurveyRespondenAnswer::avg('persepsi_value');

        return view('admin.management.surveys.index', [
            'activeMenu' => 'Management',
            'services' => $services,
            'questions' => $questions,
            'respondents' => $respondents,
            'avgScore' => $avgScore,
        ]);
    }

    public function storeQuestion(Request $request)
    {
        $data = $request->validate([
            'questioner' => ['required', 'string'],
            'label_name_1' => ['required', 'string', 'max:255'],
            'label_name_2' => ['required', 'string', 'max:255'],
            'label_name_3' => ['required', 'string', 'max:255'],
            'label_name_4' => ['required', 'string', 'max:255'],
        ]);
        SurveyQuestion::create(array_merge($data, ['is_active' => 1]));
        return back()->with('flash_success', 'Pertanyaan survei ditambahkan.');
    }
}
