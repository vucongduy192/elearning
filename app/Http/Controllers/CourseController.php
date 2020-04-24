<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enroll;
use App\Models\Student;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $courses = Course::orderBy('created_at', 'desc')->paginate($number);

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
        $user = Auth::user();
        $enroll = Enroll::where([
            'student_id' => $user->student->id,
            'course_id' => $id
        ])->first();
        $has_enrolled = $enroll ? true : false;

        $course = $this->entity->getById($id);
        return view('pages.course_details', compact('course', 'has_enrolled'));
    }
}
