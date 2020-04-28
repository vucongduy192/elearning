<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function show($id)
    {
        $lecture = Lecture::where('id', $id)->first();
        $allLectures = Lecture::where('course_id', $lecture->course_id)->get();
        return view('pages.lecture_details', compact('lecture', 'allLectures'));
    }
}
