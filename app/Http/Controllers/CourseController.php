<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enroll;
use App\Models\Student;
use App\Models\User;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    protected $entity;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->entity = $courseRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $number = 6;
        $courses = Course::join('enrolls', 'courses.id', '=', 'enrolls.course_id')
            ->groupby('courses.id')
            ->select([ 'courses.id', 'name', 'overview', 'level', 'thumbnail', 'rate', 'teacher_id', DB::raw('count(*) as enrolls')])
            ->orderBy('courses.created_at', 'desc')->paginate($number);

        $categories = Category::all();
        return view('pages.courses', compact('courses', 'categories'));
    }

    public function search(Request $request)
    {
        $number = 6;
        $courses_category_id = $request->courses_category_id;
        $name = $request->name;

        $courses = Course::when($courses_category_id, function ($query, $courses_category_id) {
            return $query->where('courses_category_id', $courses_category_id);
        })
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', '%'.$name.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($number);

        $categories = Category::all();
        session()->flashInput($request->input());
        return view('pages.courses', compact('courses', 'categories'));
    }

    public function show($id)
    {
        if (($user = Auth::user()) && $user->role_id == User::STUDENT) {
            $enroll = Enroll::where([
                'student_id' => $user->student->id,
                'course_id' => $id
            ])->first();
            $has_enrolled = $enroll ? true : false;
        } else {
            $has_enrolled = false;
        }

        $course = $this->entity->getById($id);
        return view('pages.course_details', compact('course', 'has_enrolled'));
    }

    public function enroll($id)
    {
        $course = $this->entity->getById($id);
        Enroll::create([
            'student_id' => Auth::user()->student->id,
            'course_id' => $course->id,
        ]);

        return redirect(route('courses.show', [ 'id' => $course->id ]));
    }
}
