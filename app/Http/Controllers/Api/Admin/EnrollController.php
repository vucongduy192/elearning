<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\EnrollRepository;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enroll;

class EnrollController extends Controller
{
    protected $entity;

    public function __construct(EnrollRepository $enrollRepository)
    {
        $this->entity = $enrollRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->response($this->entity->pageWithRequest($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dumpCSV()
    {
        $students = Student::join('users', 'students.user_id', '=', 'users.id')
            ->pluck("users.name", "students.id")
            ->toArray();  // array(["id" =>"name"])
        $courses = Course::pluck("name", "id")->toArray();

        # ----------------------------------------------------------------- #
        # Save csv enrollment data
        $enroll_matrix_csv = "student,".implode(",", array_values($courses))."\n";
        $courses_vector = array();

        foreach (array_keys($students) as $student_id) {
            # Assign row[enrolled items] to 1
            $row = array(); // vector users (1, 0, ...)
            foreach (array_keys($courses) as $course_id) {
                $enroll = Enroll::where(['student_id' => $student_id, 'course_id' => $course_id,])->first();
                $row[$course_id] = $enroll ? 1 : 0;
            }

            # Normalize by magnitude
            $magnitude = sqrt(array_sum($row));
            $row = array_map(function ($element) use ($magnitude) {
                return $element / $magnitude;
            }, $row);

            # Save vector to calculate similar
            array_push($courses_vector, $row);
            $enroll_matrix_csv .= $students[$student_id].",".implode(",", $row)."\n";
        }
        $filePath = public_path("recommend/enroll_matrix.csv");
        $this->saveCSV($filePath, $enroll_matrix_csv);

        # ----------------------------------------------------------------- #
        # Save csv course similar matrix by enrollment data
        $similarE_matrix_csv = "course,".implode(",", array_values($courses))."\n";
        foreach (array_keys($courses) as $c_i) {
            $row = array();
            foreach (array_keys($courses) as $c_j) {
                $c_i_vector = array_column($courses_vector, $c_i);
                $c_j_vector = array_column($courses_vector, $c_j);
                $row[$c_j] = $this->calCosineSimilar($c_i_vector, $c_j_vector);
            }
            $similarE_matrix_csv .= $courses[$c_i].",".implode(",", $row)."\n";
        }

        $filePath = public_path("recommend/similarE_matrix.csv");
        $this->saveCSV($filePath, $similarE_matrix_csv);

        return $this->response();
    }

    /**
     * Calculate CosineSimilar from 2 vector u, v
     */
    public function calCosineSimilar($u, $v)
    {
        $dot_product = array_sum(array_map( function ($u_i, $v_i) {
            return $u_i * $v_i;
        }, $u, $v));

        $u_val = sqrt(
            array_sum(array_map( function ($u_i, $u_I) {
                return $u_i * $u_I;
            }, $u, $u))
        );

        $v_val = sqrt(
            array_sum(array_map( function ($v_i, $v_I) {
                return $v_i * $v_I;
            }, $v, $v))
        );

        return $dot_product / ($u_val * $v_val);
    }

    /**
     *
     */
    public function saveCSV($filePath, $csv)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $fp = fopen($filePath, "w+");
        fwrite($fp, $csv);
        fclose($fp);
    }
}
