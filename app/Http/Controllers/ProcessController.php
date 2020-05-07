<?php

namespace App\Http\Controllers;

use App\Repositories\ProcessRepository;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    protected $process;

    public function __construct(ProcessRepository $processRepository)
    {
        $this->process = $processRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->only('course_id', 'module_id', 'student_id');
        $this->process->store($input);
        return $this->response([
            'message' => 'Update process success'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $this->process->customDestroy($request->student_id, $request->module_id);
        return $this->response([
            'message' => 'Update process success'
        ]);
    }
}
