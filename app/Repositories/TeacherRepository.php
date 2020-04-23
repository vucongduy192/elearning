<?php

namespace App\Repositories;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Transformers\TeacherTransformer;
use App\Traits\TransformPaginatorTrait;

class TeacherRepository {
    use BaseRepository, TransformPaginatorTrait;
    protected $model;

    /**
     * Constructor
     *
     * @param User $category
     */
    public function __construct(Teacher $teacher, TeacherTransformer $teacherTransformer)
    {
        $this->teacherTransformer = $teacherTransformer;
        $this->model = $teacher;
    }

    /**
     * Get list category
     */
    public function pageWithRequest(Request $request, $number = 5, $searchColumn = 'name')
    {
        $sortType = $request->get('sortType') ? $request->get('sortType') : 'desc';
        $sortColumn = $request->get('sortColumn') ? $request->get('sortColumn') : 'id';

        $teachersPaginator = $this->model
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->where($searchColumn, 'like', '%'.$request->get($searchColumn).'%')
            ->select([
                'teachers.id', 'teachers.workplace', 'teachers.expert',  
                'users.name', 'users.email', 'users.avatar',
            ])
            ->orderBy($sortColumn, $sortType)
            ->paginate($number);
        
        return $this->buildTransformPaginator(
            $teachersPaginator, 
            $this->teacherTransformer
        );
    }
}