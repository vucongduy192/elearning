<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Course;
use App\Repositories\CourseRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct(CourseRepository $courseRepository, TeacherRepository $teacherRepository)
    {
        $this->course = $courseRepository;
        $this->teacher = $teacherRepository;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $popular_courses = $this->course->popularCourse();
        $best_teachers = $this->teacher->bestTeacher();

        return view('pages.home', compact('popular_courses', 'best_teachers'));
    }

    public function errors(Request $request)
    {
        $error = $request->error;
        $message = $request->message;
        return view('pages.errors', compact('error', 'message'));
    }
}
