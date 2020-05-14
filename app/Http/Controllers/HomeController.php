<?php

namespace App\Http\Controllers;

use App\Repositories\BlogRepository;
use App\Repositories\CourseRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $course, $teacher, $blog;

    public function __construct(CourseRepository $courseRepository, TeacherRepository $teacherRepository,
                                BlogRepository $blogRepository)
    {
        $this->course = $courseRepository;
        $this->teacher = $teacherRepository;
        $this->blog = $blogRepository;
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
        $newest_blogs = $this->blog->newestBlog(3);

        return view('pages.home', compact('popular_courses', 'best_teachers', 'newest_blogs'));
    }

    public function errors(Request $request)
    {
        $error = $request->error;
        $message = $request->message;
        return view('pages.errors', compact('error', 'message'));
    }
}
