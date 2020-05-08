<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use App\Models\Teacher;
use App\Repositories\BaseRepository;
use App\Traits\TransformPaginatorTrait;
use App\Traits\UploadTrait;
use App\Transformers\CourseTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseRepository
{
    use BaseRepository, UploadTrait, TransformPaginatorTrait;
    protected $model, $courseTransformer;

    /**
     * Constructor
     *
     * @param Course $category
     */
    public function __construct(Course $course, CourseTransformer $courseTransformer)
    {
        $this->courseTransformer = $courseTransformer;
        $this->model = $course;
    }

    /**
     * Get list category
     */
    public function pageWithRequest(Request $request, $number=5)
    {
        $searchColumn = ['name', 'courses_category_id', 'teacher_id'];

        $sortType = $request->get('sortType') ? $request->get('sortType') : 'desc';
        $sortColumn = $request->get('sortColumn') ? $request->get('sortColumn') : 'id';
        $courses_category_id = $request->get($searchColumn[1]);
        $teacher_id = (Auth::user()->role_id == 2) ? -1 : Auth::user()->teacher->id;

        $coursesPaginator = $this->model
            ->join('teachers', 'courses.teacher_id', '=', 'teachers.id')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->leftJoin('enrolls', 'courses.id', '=', 'enrolls.course_id')
            ->groupby('courses.id')
            ->select([
                'courses.id', 'courses.name', 'courses.overview', 'level', 'courses.thumbnail', 'courses_category_id',
                'teachers.id as teacher_id',
                'users.name as teacher',
                DB::raw('count(*) as enrolls')
            ])
            ->where('courses.' . $searchColumn[0], 'like', '%' . $request->get($searchColumn[0]) . '%')
            ->when($courses_category_id != -1, function ($query) use ($courses_category_id) {
                return $query->where('courses_category_id', $courses_category_id);
            })
            ->when($teacher_id != -1, function ($query) use ($teacher_id) {
                return $query->where('teacher_id', $teacher_id);
            })
            ->orderBy($sortColumn, $sortType)
            ->paginate($number);

        return $this->buildTransformPaginator(
            $coursesPaginator,
            $this->courseTransformer
        );
    }

    /**
     * Store a new category.
     *
     * @param  $input
     * @return
     */
    public function customStore(CourseRequest $request)
    {
        $input = $request->only(['name', 'overview', 'price', 'level', 'teacher_id', 'courses_category_id']);
        if (empty($input['teacher_id']))
            $input['teacher_id'] = Teacher::TEACHER_ADMIN_ID;

        $input['thumbnail'] = $this->uploadImage($request,
            $image_name = 'thumbnail', $folder = 'course',
            $w = Course::THUMBNAIL_WIDTH, $h = Course::THUMBNAIL_HEIGHT);

        return $this->store($input);
    }

    /**
     * Update a new category.
     *
     * @param  $input
     * @return
     */
    public function customUpdate(CourseRequest $request, $id)
    {
        $input = $request->only(['name', 'overview', 'price', 'level', 'teacher_id', 'courses_category_id']);
        $new_thumbnail = $this->uploadImage($request,
            $image_name = 'thumbnail', $folder = 'course',
            $w = Course::THUMBNAIL_WIDTH, $h = Course::THUMBNAIL_HEIGHT);

        if ($new_thumbnail != '') {
            $input['thumbnail'] = $new_thumbnail;
            $this->removeFile($this->getById($id)->thumbnail);
        }

        return $this->update($id, $input);
    }

    /**
     * Destroy a new category.
     *
     * @param  $input
     * @return
     */
    public function customDestroy($id)
    {
        $this->removeFile($this->getById($id)->thumbnail);
        $this->destroy($id);
    }

    /**
     * Get courses in top enrolled
     *
     * @return mixed
     */
    public function popularCourse()
    {
        return $this->model->join('enrolls', 'courses.id', '=', 'enrolls.course_id')
            ->groupby('courses.id')
            ->select([ 'courses.id', 'name', 'overview', 'level', 'thumbnail', 'rate', 'teacher_id', DB::raw('count(*) as enrolls')])
            ->orderBy('enrolls', 'desc')
            ->limit(3)->get();
    }

    public function filterCourse($number, $name=null, $teacher=null, $courses_category_id=null)
    {
        return $this->model->join('enrolls', 'courses.id', '=', 'enrolls.course_id')
            ->join('teachers', 'courses.teacher_id', '=', 'teachers.id')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->groupby('courses.id')
            ->select([ 'courses.id', 'courses.name', 'courses.overview', 'courses.level', 'courses.thumbnail',
                       'courses.rate', 'courses.teacher_id', DB::raw('count(*) as enrolls'),
                       'users.name as teacher_name'
            ])
            ->when($courses_category_id, function ($query, $courses_category_id) {
                return $query->where('courses_category_id', $courses_category_id);
            })
            ->when($name, function ($query, $name) {
                return $query->where('courses.name', 'like', '%'.$name.'%');
            })
            ->when($teacher, function ($query, $teacher) {
                return $query->where('users.name', 'like', '%'.$teacher.'%');
            })
            ->orderBy('courses.created_at', 'desc')
            ->paginate($number);
    }
}
