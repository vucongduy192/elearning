<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\CourseRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProfessorController extends Controller
{
    protected $professor, $category, $course;

    public function __construct(TeacherRepository $teacherRepository, CategoryRepository $categoryRepository,
                                CourseRepository $courseRepository)
    {
        $this->professor = $teacherRepository;
        $this->category = $categoryRepository;
        $this->course = $courseRepository;
    }

    public function index()
    {
        $best_teachers = $this->professor->bestTeacher();
        $best_teacher_in_fields = array();
        foreach ($this->category->all() as $category) {
            $best_teacher_in_fields[$category->name] = $this->professor->bestTeacher($courses_category_id=$category->id)->first();
        }
        return view('pages.professors', compact('best_teachers', 'best_teacher_in_fields'));
    }

    public function show($id)
    {
        $professor = $this->professor->getById($id);
        return view('pages.professor_details', compact('professor'));
    }

    public function professor_courses(Request $request)
    {
        $number = 3;
        $courses = $this->course->filterCourse($number, null, null, null,
            $teacher_id=$request->professor_id);
        return $this->response([
            'html' => View::make('components.courses_list')->with(['courses' => $courses])->render()
        ]);
    }
}
