<?php

namespace App\Repositories;

use App\Models\Module;
use App\Repositories\BaseRepository;
use App\Repositories\LectureRepository;

class ModuleRepository {
    use BaseRepository;
    protected $model, $lecture;

    /**
     * Constructor
     *
     * @param Module $module
     */
    public function __construct(Module $module, LectureRepository $lectureRepository)
    {
        $this->model = $module;
        $this->lecture = $lectureRepository;
    }

    /**
     * Delete module and each lectures in module
     * @param $id
     */
    public function customDestroy($id)
    {
        $module = $this->getById($id);
        foreach ($module->lectures as $lecture) {
            $this->lecture->customDestroyOne($lecture->id);
        }
        $this->destroy($id);
    }

    public function allModules($course_id)
    {
        return $this->model->where('course_id', $course_id)->get();
    }
}
