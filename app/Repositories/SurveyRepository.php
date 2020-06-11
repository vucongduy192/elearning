<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Survey;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\SurveyRank;
use App\Models\Duration;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;

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

    public function studentSurveyCategory($student_id)
    {
        return Category::leftJoin('surveys', function($join) use ($student_id) {
            $join->on('surveys.courses_category_id', '=', 'course_categories.id')
                 ->where('surveys.student_id', '=', $student_id);
        })
        ->select(['course_categories.id', 'course_categories.name', 'surveys.id as interest'])
        ->orderBy('course_categories.id')
        ->get();
    }

    /**
     * Survey if student interested with courses from these teachers
     */
    public function studentSurveyTeacher($student_id)
    {
        return Teacher::leftJoin('survey_teachers', function($join) use ($student_id) {
            $join->on('survey_teachers.teacher_id', '=', 'teachers.id')
                 ->where('survey_teachers.student_id', '=', $student_id);
        })
        ->join('users', 'teachers.user_id', '=', 'users.id')
        ->select(['teachers.id', 'users.name', 'survey_teachers.id as interest'])
        ->orderBy('teachers.id')
        ->get();
    }

    /**
     * Survey if student interested with courses from these teachers
     */
    public function studentSurveyRank($student_id)
    {         
        $durations = Duration::leftJoin('survey_ranks', function($join) use ($student_id) {
            $join->on('survey_ranks.duration_id', '=', 'durations.id')
                 ->where('survey_ranks.student_id', '=', $student_id);
        })
        ->select(['durations.*'])
        ->distinct()
        ->get();

        $partners = Partner::leftJoin('survey_ranks', function($join) use ($student_id) {
            $join->on('survey_ranks.partner_id', '=', 'partners.id')
                 ->where('survey_ranks.student_id', '=', $student_id);
        })
        ->select(['partners.*'])
        ->distinct()
        ->get();

        return [
            'ranks' => SurveyRank::where('survey_ranks.student_id', '=', $student_id)->first(),
            'durations' => $durations,
            'partners' => $partners
        ];
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
        $student = Auth::user()->student;
        $categories_id = $student->survey->pluck('courses_category_id')->toArray();
        $survey_ranks = $student->survey_ranks;
        
        if (empty($survey_ranks))
            return [];
        $price = ($survey_ranks->free == 1) ? 0.1 : 100000;
        $level = $survey_ranks->level;
        $partner_id = $survey_ranks->partner_id;
        $duration_id = $survey_ranks->duration_id;

        $courses = Course::join('course_categories', 'courses.courses_category_id', 'course_categories.id')
            ->whereIn('course_categories.id', $categories_id)
            ->when($level, function ($query, $level) {
                return $query->where('level', $level);
            })
            ->when($partner_id, function ($query, $partner_id) {
                return $query->where('partner_id', $partner_id);
            })
            ->when($duration_id, function ($query, $duration_id) {
                return $query->where('duration_id', $duration_id);
            })
            ->when($price, function ($query, $price) {
                return $query->where('price', '<=', $price);
            })
            ->orderBy('courses.rate')
            ->select(['courses.*'])
            ->get();
            
        if (count($courses) == 0)
            return [];
        
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

        $top_course = array_slice($recommend_courses, 0, 3);
        $top_id = array_column($top_course, 'id');
        return Course::whereIn('courses.id', $top_id)
            ->join('teachers', 'courses.teacher_id', '=', 'teachers.id')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->leftJoin('enrolls', 'courses.id', '=', 'enrolls.course_id')
            ->groupby('courses.id')
            ->select([ 'courses.id', 'courses.name', 'courses.overview', 'courses.level', 'courses.thumbnail',
                'courses.rate', 'courses.teacher_id', 'courses.price', DB::raw('count(*) as enrolls'),
                'users.name as teacher_name', 
            ])
            ->get();
    }
}
