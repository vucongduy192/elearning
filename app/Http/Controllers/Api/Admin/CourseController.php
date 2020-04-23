<?php

namespace App\Http\Controllers\Api\Admin;

use App\Repositories\CourseRepository;
use App\Repositories\LectureRepository;
use App\Http\Controllers\Controller;
use App\Transformers\CourseTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;

class CourseController extends Controller
{
    protected $entity, $sub_entity;
    
    public function __construct(CourseRepository $courseRepository, LectureRepository $lectureRepository)
    {
        $this->entity = $courseRepository;
        $this->sub_entity = $lectureRepository;
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
        foreach ($request->lectures as $lecture) {
            $this->sub_entity->customStore($lecture, $course->id);    
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
        $new_lectures_request = isset($request->lectures) ? array_map(function ($arr) { return $arr['id']; }, $request->lectures) 
                                                          : [];
        # Remove old lectures
        foreach ($course->lectures as $lecture) {
            if (!in_array($lecture->id, $new_lectures_request)) {
                $this->sub_entity->customDestroyOne($lecture->id);
            }
        }
        # Add or update new lectures
        foreach ($request->lectures as $lecture) {
            if ($lecture['id'] == -1) {
                $this->sub_entity->customStore($lecture, $course->id); // add new lecture
            } else {
                $this->sub_entity->customUpdate($lecture, $lecture['id'], $course->id);
            }
        }
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
        $this->sub_entity->customDestroyAll($course);
        $this->entity->customDestroy($id);
    }
}
