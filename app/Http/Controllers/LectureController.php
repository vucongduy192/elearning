<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Module;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function show($id)
    {
        $lecture = Lecture::where('id', $id)->first();
        $allModules = Module::where('course_id', $lecture->module->course->id)->get();
        return view('pages.lecture_details', compact('lecture', 'allModules'));
    }
}
