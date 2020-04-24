<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $popular_courses = Course::join('enrolls', 'courses.id', '=', 'enrolls.course_id')
            ->groupby('courses.id')
            ->select([ 'name', 'overview', 'level', 'thumbnail', 'teacher_id', DB::raw('count(*) as enrolls')])
            ->orderBy('enrolls', 'desc')
            ->limit(3)->get();

        $best_teachers = Teacher::join('courses', 'teachers.id', '=', 'courses.teacher_id')
            ->join('enrolls', 'courses.id', '=', 'enrolls.course_id')
            ->groupby('teachers.id')
            ->select(['teachers.id as id', 'teachers.expert', 'teachers.workplace', 'teachers.user_id', DB::raw('count(*) as enrolls')])
            ->orderBy('enrolls', 'desc')
            ->limit(3)->get();

        return view('pages.home', compact('popular_courses', 'best_teachers'));
    }
}
