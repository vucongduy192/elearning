<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\TeacherRepository;

class DashboardController extends Controller
{
    protected $course, $teacher;

    public function __construct(CourseRepository $courseRepository, TeacherRepository $teacherRepository)
    {
        $this->course = $courseRepository;
        $this->teacher = $teacherRepository;
    }

    public function index(Request $request)
    {
        $popular_courses = $this->course->popularCourse($number=5);
        $best_teachers = $this->teacher->bestTeacher();

        return $this->response([
            'top_courses' => $popular_courses,
            'best_professors' => $best_teachers,
        ]);
    }
}
