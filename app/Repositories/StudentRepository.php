<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Transformers\StudentTransformer;
use App\Traits\TransformPaginatorTrait;

class StudentRepository {
    use BaseRepository, TransformPaginatorTrait;
    protected $model;

    /**
     * Constructor
     *
     * @param User $category
     */
    public function __construct(Student $student, StudentTransformer $studentTransformer)
    {
        $this->studentTransformer = $studentTransformer;
        $this->model = $student;
    }

    /**
     * Get list category
     */
    public function pageWithRequest(Request $request, $number = 8, $searchColumn = 'name')
    {
        $sortType = $request->get('sortType') ? $request->get('sortType') : 'desc';
        $sortColumn = $request->get('sortColumn') ? $request->get('sortColumn') : 'id';

        $studentsPaginator = $this->model
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where($searchColumn, 'like', '%'.$request->get($searchColumn).'%')
            ->select([
                'students.id', 'students.school', 'students.major',  
                'users.name', 'users.email', 'users.avatar',
            ])
            ->orderBy($sortColumn, $sortType)
            ->paginate($number);
        
        return $this->buildTransformPaginator(
            $studentsPaginator, 
            $this->studentTransformer
        );
    }
}