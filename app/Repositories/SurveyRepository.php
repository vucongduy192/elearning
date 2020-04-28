<?php

namespace App\Repositories;

use App\Models\Survey;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Models\Category;

class SurveyRepository
{
    use BaseRepository;
    protected $model;

    /**
     * Constructor
     *
     * @param Category $category
     */
    public function __construct(Survey $survey)
    {
        $this->model = $survey;
    }

    public function studentSurvey($student_id)
    {
        return Category::leftJoin('surveys', function($join) use ($student_id) {
            $join->on('surveys.courses_category_id', '=', 'course_categories.id')
                 ->where('surveys.student_id', '=', $student_id);
        })
        ->select(['course_categories.id', 'course_categories.name', 'surveys.id as interest'])
        ->orderBy('course_categories.id')
        ->get();
    }

    public function destroyByStudentId($student_id)
    {
        return $this->model->where('student_id', $student_id)->delete();
    }
}
