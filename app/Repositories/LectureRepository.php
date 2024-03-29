<?php

namespace App\Repositories;

use App\Models\Lecture;
use App\Repositories\BaseRepository;
use App\Traits\UploadTrait;

class LectureRepository {
    use BaseRepository, UploadTrait;
    protected $model;

    /**
     * Constructor
     *
     * @param Lecture $lecture
     */
    public function __construct(Lecture $lecture)
    {
        $this->model = $lecture;
    }

    /**
     * Store a new category.
     *
     * @param  $input
     * @return 
     */
    public function customStore($lecture, $course_id, $module_id)
    {
        $lecture['slide'] = $this->uploadSlide($lecture['slide'], $course_id, $module_id);
        $lecture['module_id'] = $module_id;
        # ko hieu sao cho nay ko dung $this->store dc
        # neu dung thi no chi luu cai lecture cuoi (ko phai do transaction) 
        $this->model->create($lecture);
    }

    /**
     * Store a new category.
     *
     * @param  $input
     * @return 
     */
    public function customUpdate($lecture, $id, $course_id, $module_id)
    {
        $new_slide = $this->uploadSlide($lecture['slide'], $course_id, $module_id);
        if ($new_slide != '') {
            $lecture['slide'] = $new_slide;
            $this->removeFile($this->getById($id)->slide);
        }
        $lecture['module_id'] = $module_id;
        $this->update($id, $lecture);
    }

    /**
     * Destroy a new category.
     *
     * @param  $input
     * @return 
     */
    public function customDestroyOne($id)
    {
        $this->removeFile($this->getById($id)->slide);
        $this->destroy($id);
    }

    /**
     * Store a new category.
     *
     * @param  $input
     * @return 
     */
    public function customDestroyAll($course)
    {
        $dir = '/public/slide/'.$course->id.'/';    # dir in storage/app/public/slide/{}
        $this->removeFolder($dir);
        foreach ($course->lectures as $lecture) {
            $this->destroy($lecture->id);
        }
    }
}