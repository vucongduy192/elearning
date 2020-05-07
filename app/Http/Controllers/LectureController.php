<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Module;
use App\Repositories\LectureRepository;
use App\Repositories\ModuleRepository;
use App\Repositories\ProcessRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    protected $lecture, $module, $process;
    public function __construct(LectureRepository $lectureRepository, ModuleRepository $moduleRepository,
                                ProcessRepository $processRepository)
    {
        $this->lecture = $lectureRepository;
        $this->module = $moduleRepository;
        $this->process = $processRepository;
    }

    public function show($id)
    {
        $lecture = $this->lecture->getById($id);
        $allModules = $this->module->allModules($lecture->module->course->id);
        $module_processed = $this->process->getModuleProcessed(Auth::user()->student->id);

        return view('pages.lecture_details', compact('lecture', 'allModules', 'module_processed'));
    }
}
