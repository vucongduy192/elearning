<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    protected $professor, $category;

    public function __construct(TeacherRepository $teacherRepository, CategoryRepository $categoryRepository)
    {
        $this->professor = $teacherRepository;
        $this->category = $categoryRepository;
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
}
