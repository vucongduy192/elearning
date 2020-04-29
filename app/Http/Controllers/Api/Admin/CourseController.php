<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\CourseRepository;
use App\Repositories\ModuleRepository;
use App\Http\Controllers\Controller;
use App\Transformers\CourseTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;

class CourseController extends Controller
{
    protected $entity, $sub_entity;

    public function __construct(CourseRepository $courseRepository, ModuleRepository $moduleRepository)
    {
        $this->entity = $courseRepository;
        $this->sub_entity = $moduleRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->response($this->entity->pageWithRequest($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $course = $this->entity->customStore($request);

         $request->lectures = isset($request->lectures) ? $request->lectures : [];
         foreach ($request->modules as $module) {
             $module['course_id'] = $course->id;
             $this->sub_entity->create($module);
         }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = $this->entity->getById($id);
        $transformer = new CourseTransformer();
        return $this->response($transformer->transform($course));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, $id)
    {
        $course = $this->entity->customUpdate($request, $id);
        $new_modules_request = isset($request->modules) ? array_map(function ($arr) { return $arr['id']; }, $request->modules)
                                                          : [];
        # Remove old lectures
        foreach ($course->modules as $module) {
            if (!in_array($module->id, $new_modules_request)) {
                $this->sub_entity->customDestroy($module->id);
            }
        }

        # Add or update new lectures
        if ($request->modules)
            foreach ($request->modules as $module) {
                $module['course_id'] = $course->id;
                if ($module['id'] == -1) {
                    $this->sub_entity->create($module); // add new lecture
                } else {
                    $this->sub_entity->update($module['id'], $module);
                }
            }

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = $this->entity->getById($id);
        foreach ($course->modules as $module) {
            $this->sub_entity->customDestroy($module->id);
        }
        $this->entity->customDestroy($id);
    }
}
// Baisc