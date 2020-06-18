<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\CourseRepository;
use App\Repositories\EnrollRepository;
use App\Repositories\ProcessRepository;
use App\Repositories\SurveyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CourseController extends Controller
{
    protected $course, $survey, $enroll, $process, $category;

    public function __construct(CourseRepository $courseRepository, EnrollRepository $enrollRepository,
                                SurveyRepository $surveyRepository, ProcessRepository $processRepository,
                                CategoryRepository $categoryRepository)
    {
        $this->course = $courseRepository;
        $this->enroll = $enrollRepository;
        $this->survey = $surveyRepository;
        $this->process = $processRepository;
        $this->category = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $number = 6;
        // $courses = $this->course->filterCourse($number);
        $categories = $this->category->all();
        $header_search_name = $request->name;
        return view('pages.courses', compact('categories', 'header_search_name'));
    }

    public function search(Request $request)
    {
        $number = 6;
        $courses_category_id = $request->courses_category_id;
        $name = $request->name;
        $teacher = $request->teacher;

        $courses = $this->course->filterCourse($number, $name, $teacher, $courses_category_id);
        return $this->response([
            'html' => View::make('components.courses_list')->with(['courses' => $courses])->render()
        ]);
    }

    /**
     * Course details include: syllabus + overview + reviews ...
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $has_enrolled = false;  // check if current user has enrolled this course
        $recommend_courses = $this->course->popularCourse();
        $module_processed = array();

        if (($user = Auth::user()) && $user->role_id == User::STUDENT) {
            $enroll = $this->enroll->getByCondition($id, $user->student->id);
            $has_enrolled = $enroll ? true : false;

            $recommend_courses = (count($user->student->enrolled) == 0)
                ? $this->survey->recommend()
                : $this->enroll->recommend()['top_courses'];

            $module_processed = $this->process->getModuleProcessed($user->student->id);
        }

        $course = $this->course->getById($id);
        return view('pages.course_details', compact('course', 'has_enrolled', 'recommend_courses', 'module_processed'));
    }

    /**
     * Student enroll a course
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function enroll($id)
    {
        $course = $this->course->getById($id);
        $this->enroll->store([
            'student_id' => Auth::user()->student->id,
            'course_id' => $course->id,
        ]);

        return redirect(route('courses.show', [ 'id' => $course->id ]))
            ->with('message', 'Enroll course success');
    }
}
