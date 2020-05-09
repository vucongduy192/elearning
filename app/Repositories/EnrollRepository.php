<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Enroll;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Transformers\EnrollTransformer;
use App\Traits\TransformPaginatorTrait;
use Illuminate\Support\Facades\Auth;

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
        $teacher_id = (Auth::user()->role_id == 2) ? -1 : Auth::user()->teacher->id;

        $enrollsPaginator = $this->model
            ->join('students', 'enrolls.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('courses', 'enrolls.course_id', '=', 'courses.id')
            ->where([
                ['courses.name', 'like', '%'.$request->get($searchColumn[0]).'%'],
                ['users.name', 'like', '%'.$request->get($searchColumn[1]).'%']
            ])
            ->when($teacher_id != -1, function ($query) use ($teacher_id) {
                return $query->where('teacher_id', $teacher_id);
            })
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

    /**
     * Get all enrollment of a student
     * @param $student_id
     * @return mixed
     */
    public function getByStudentId($student_id)
    {
        return $this->model
            ->where('student_id', $student_id)
            ->orderBy('created_at', 'desc')->get();
    }

    public function getByCondition($course_id, $student_id)
    {
        return $this->model->where([
            'course_id' => $course_id,
            'student_id' => $student_id,
        ])->first();
    }
    /**
     * Recommend by enrollment data + rule category
     * @return mixed
     */
    public function recommend()
    {
        $sim_csv_path = public_path("recommend/similar_matrix.csv");
        $file = fopen($sim_csv_path, 'r');
        $row = fgetcsv($file, 0, ',');

        $student = Auth::user()->student;
        $index_2_id = Course::pluck("id")->toArray();
        $id_2_index = array_flip($index_2_id);

        $courses = Course::pluck("name", "id")->toArray();  // array(["id" =>"name"])
        $enrolled = $this->model->join('courses', 'enrolls.course_id', '=', 'courses.id')
            ->where('student_id', $student->id)
            ->pluck("courses.name", "courses.id")
            ->toArray();
        $non_enrolled = array_diff($courses, $enrolled);

        $scores = array_fill_keys(array_keys($non_enrolled), 0);
        foreach ($non_enrolled as $c_i => $str_i) {
            # Find until get vector $c_i
            while ($row[0] != $str_i) {
                $row = fgetcsv($file, 0, ',');
            }

            $similar = array_fill_keys(array_keys($enrolled), 0);
            # Find maximun similar btw c_i vs each c_j of all enroleld course
            foreach (array_keys($enrolled) as $c_j) {
                $similar[$c_j] = $row[$id_2_index[$c_j] + 1];
            }
            arsort($similar);    # sort by value similar
            $scores[$c_i] = array_sum(array_splice($similar, 0, 3));
        }

        arsort($scores);
        if (sizeof($scores) >= 3)
            $top_id = array_keys(array_slice($scores, 0, 3, true));
        else {
            $top_id = array_keys($scores);
        }

        return Course::whereIn('id', $top_id)->get();
    }


}
