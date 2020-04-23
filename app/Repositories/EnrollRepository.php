<?php

namespace App\Repositories;

use App\Models\Enroll;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Transformers\EnrollTransformer;
use App\Traits\TransformPaginatorTrait;

class EnrollRepository {
    use BaseRepository, TransformPaginatorTrait;
    protected $model;

    /**
     * Constructor
     *
     * @param Enroll $enroll
     */
    public function __construct(Enroll $enroll, EnrollTransformer $enrollTransformer)
    {
        $this->enrollTransformer = $enrollTransformer;
        $this->model = $enroll;
    }

    /**
     * Get list category
     */
    public function pageWithRequest(Request $request, $number = 5, $searchColumn=['course_name', 'username'])
    {
        $sortType = $request->get('sortType') ? $request->get('sortType') : 'desc';
        $sortColumn = $request->get('sortColumn') ? $request->get('sortColumn') : 'id';

        $enrollsPaginator = $this->model
            ->join('students', 'enrolls.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('courses', 'enrolls.course_id', '=', 'courses.id')
            ->where([
                ['courses.name', 'like', '%'.$request->get($searchColumn[0]).'%'],
                ['users.name', 'like', '%'.$request->get($searchColumn[1]).'%']
            ])
            ->select([
                'enrolls.id as id', 'enrolls.student_id', 'enrolls.course_id',
                'courses.name as course_name', 'courses.courses_category_id',
                'users.name as username', 
            ])
            ->orderBy($sortColumn, $sortType)
            ->paginate($number);

        return $this->buildTransformPaginator(
            $enrollsPaginator, 
            $this->enrollTransformer
        );
    }
}