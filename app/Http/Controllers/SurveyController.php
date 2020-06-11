<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyRank;
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
        $survey = $this->survey->studentSurveyCategory($student->id);
        $surveyRank = $this->survey->studentSurveyRank($student->id);
        // $surveyTeacher = $this->survey->studentsurveyTeacher($student->id);

        return view('pages.survey', compact('student', 'survey', 'surveyRank'));
    }

    public function update(Request $request)
    {
        $this->survey->destroyByStudentId($request->student_id);
        // Update survey_category
        if ($request->category_id) {
            foreach ($request->category_id as $category_id) {
                $this->survey->create([
                    'student_id' => $request->student_id,
                    'courses_category_id' => $category_id
                ]);
            }
        }

        // Update survey_ranks
        $input = $request->only('level', 'duration_id', 'partner_id', 'free', 'student_id');
        $input['free'] = empty($input['free']) ? 0 : 1;
        $survey_rank = SurveyRank::where('student_id', $request->student_id)->first();
        if ($survey_rank) {
            SurveyRank::where('student_id', $request->student_id)
                ->update($input);
        } else {
            $new_survey_rank = SurveyRank::create($input);
            $new_survey_rank->save();    
        }

        return redirect(route('survey.show'))->with('message', 'Update survey success');
    }

}
