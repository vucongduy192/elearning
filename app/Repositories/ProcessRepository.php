<?php

namespace App\Repositories;

use App\Models\Process;
use App\Repositories\BaseRepository;

class ProcessRepository {
    use BaseRepository;
    protected $model;

    /**
     * Constructor
     *
     * @param Process $process
     */
    public function __construct(Process $process)
    {
        $this->model = $process;
    }

    public function getModuleProcessed($student_id)
    {
        return $this->model->where('student_id', $student_id)
            ->pluck('module_id')->toArray();
    }

    public function customDestroy($student_id, $module_id)
    {
        return $this->model->where([
            'student_id' => $student_id,
            'module_id' => $module_id,
        ])->delete();
    }
}
