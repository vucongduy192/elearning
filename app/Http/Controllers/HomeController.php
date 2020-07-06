<?php

namespace App\Http\Controllers;

use App\Repositories\BlogRepository;
use App\Repositories\CourseRepository;
use App\Repositories\SurveyRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\EnrollRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    protected $course, $teacher, $blog, $enroll, $survey;

    public function __construct(CourseRepository $courseRepository, TeacherRepository $teacherRepository,
                                BlogRepository $blogRepository, EnrollRepository $enrollRepository, SurveyRepository $surveyRepository)
    {
        $this->course = $courseRepository;
        $this->teacher = $teacherRepository;
        $this->blog = $blogRepository;
        $this->enroll = $enrollRepository;
        $this->survey = $surveyRepository;
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
        $recommend_courses = [];

        if (($user = Auth::user()) && $user->role_id == User::STUDENT) {
            $recommend_courses = (count($user->student->enrolled) == 0)
                ? $this->survey->recommend()
                : $this->enroll->recommend()['top_courses'];
        }

        return view('pages.home', compact('popular_courses', 'best_teachers', 'newest_blogs', 'recommend_courses'));
    }

    public function errors(Request $request)
    {
        $error = $request->error;
        $message = $request->message;
        return view('pages.errors', compact('error', 'message'));
    }
}
