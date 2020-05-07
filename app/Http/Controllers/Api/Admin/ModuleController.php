<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\ModuleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ModuleRepository;
use App\Repositories\LectureRepository;
use App\Transformers\ModuleTransformer;

class ModuleController extends Controller
{
    protected $entity, $sub_entity;

    public function __construct(ModuleRepository $moduleRepository, LectureRepository $lectureRepository)
    {
        $this->entity = $moduleRepository;
        $this->sub_entity = $lectureRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $module = $this->entity->getById($id);
        $transformer = new ModuleTransformer();
        return $this->response($transformer->transform($module));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleRequest $request, $id)
    {
        $input = $request->only(['name', 'overview']);
        $module = $this->entity->update($id, $input);
        $new_lectures_request = isset($request->lectures) ? array_map(function ($arr) { return $arr['id']; }, $request->lectures)
                                                          : [];
        # Remove old lectures
        foreach ($module->lectures as $lecture) {
            if (!in_array($lecture->id, $new_lectures_request)) {
                $this->sub_entity->customDestroyOne($lecture->id);
            }
        }

        # Add or update new lectures
        if ($request->lectures)
            foreach ($request->lectures as $lecture) {
                if ($lecture['id'] == -1) {
                    $this->sub_entity->customStore($lecture, $module->course->id, $module->id); // add new lecture
                } else {
                    $this->sub_entity->customUpdate($lecture, $lecture['id'], $module->course->id, $module->id);
                }
            }

        return $this->response();
    }
}
