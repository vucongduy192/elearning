<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Survey;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

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

    /**
     * With survey: student choose some interested category
     * @return array
     */
    public function recommend()
    {
        $student  = Auth::user()->student;
        $categories_id = $student->survey->pluck('courses_category_id')->toArray();
        $courses = Course::join('course_categories', 'courses.courses_category_id', 'course_categories.id')
            ->whereIn('course_categories.id', $categories_id)
            ->orderBy('courses.rate')
            ->select(['courses.*'])
            ->get();

        $recommend_courses = array();
        // Get first course from each category untils recommend_courses length equals 3
        while(count($recommend_courses) < 3) {
            $copy_categories_id = $categories_id;
            foreach ($courses as $c) {
                if (in_array($c->courses_category_id, $copy_categories_id)) {
                    array_push($recommend_courses, $c);

                    $copy_categories_id = array_diff($copy_categories_id, [$c->courses_category_id]);
                    $courses = $courses->except($c->id);
                }
            }
        }

        return array_slice($recommend_courses, 0, 3);
    }
}
