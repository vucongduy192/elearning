<?php

namespace App\Repositories;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Transformers\TeacherTransformer;
use App\Traits\TransformPaginatorTrait;
use Illuminate\Support\Facades\DB;

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
    public function pageWithRequest(Request $request, $number = 8, $searchColumn = 'name')
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

    /**
     * @param $courses_category_id: each category choose best teacher
     * @return mixed
     */
    public function bestTeacher($courses_category_id=null)
    {
        return $this->model->join('courses', 'teachers.id', '=', 'courses.teacher_id')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->join('enrolls', 'courses.id', '=', 'enrolls.course_id')
            ->groupby('teachers.id')
            ->select([
                'teachers.id as id', 'teachers.expert', 'teachers.workplace', 'teachers.user_id', 
                'users.name', 'users.email', 'users.avatar',
                DB::raw('count(*) as enrolls')
            ])
            ->when($courses_category_id, function ($query, $courses_category_id) {
                return $query->where('courses_category_id', $courses_category_id);
            })
            ->orderBy('enrolls', 'desc')
            ->limit(3)->get();
    }
}
