<?php

namespace App\Repositories;

use App\Helpers\CollectionHelper;
use App\Models\Process;

class ProcessRepository {
    use BaseRepository;
    protected $model, $enroll;

    /**
     * Constructor
     *
     * @param Process $process
     */
    public function __construct(Process $process, EnrollRepository $enrollRepository)
    {
        $this->model = $process;
        $this->enroll = $enrollRepository;
    }

    /**
     * @param $student_id
     * @return mixed
     */
    public function getModuleProcessed($student_id)
    {
        return $this->model->where('student_id', $student_id)
            ->pluck('module_id')->toArray();
    }

    /**
     * @param $student_id
     * @param $module_id
     * @return mixed
     */
    public function customDestroy($student_id, $module_id)
    {
        return $this->model->where([
            'student_id' => $student_id,
            'module_id' => $module_id,
        ])->delete();
    }

    /**
     * @param $student_id
     * @param $course_id
     * @return mixed
     */
    public function getByCondition($student_id, $course_id)
    {
        return $this->model->where([
            'student_id' => $student_id,
            'course_id' => $course_id,
        ])->get();
    }

    /**
     * @param $student_id
     * @param bool $completed
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getEnrolledWithProcess($student_id, $completed=0)
    {
        $enrolled = $this->enroll->getByStudentId($student_id);
        foreach($enrolled as $key => $e) {
            $num_processed = count($this->getByCondition($student_id, $e->course->id));
            $num_modules = $e->course->modules ? count($e->course->modules) : 0;

            $e['completed'] = ($num_modules == $num_processed) ? 1 : 0;
            if ($e['completed'] != $completed)
                unset($enrolled[$key]);
        }

        $total = count($enrolled);
        $pageSize = 3;
        return CollectionHelper::paginate($enrolled, $total, $pageSize);
    }
}
