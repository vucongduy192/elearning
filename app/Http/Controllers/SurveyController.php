<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Repositories\SurveyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;

class SurveyController extends Controller
{
    protected $survey;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->survey = $surveyRepository;
    }

    public function show()
    {
        $student = Auth::user()->student;
        $survey = $this->survey->studentSurvey($student->id);
        $surveyRank = $this->survey->studentSurveyRank($student->id);
        $surveyTeacher = $this->survey->studentsurveyTeacher($student->id);
        // dd($surveyRank);
        return view('pages.survey', compact('student', 'survey', 'surveyRank', 'surveyTeacher'));
    }

    public function update(Request $request)
    {
        $this->survey->destroyByStudentId($request->student_id);
        if ($request->category_id) {
            foreach ($request->category_id as $category_id) {
                $this->survey->create([
                    'student_id' => $request->student_id,
                    'courses_category_id' => $category_id
                ]);
            }
        }
        return redirect(route('survey.show'))->with('message', 'Update survey success');
    }

}
