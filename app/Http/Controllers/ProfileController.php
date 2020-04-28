<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enroll;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $entity;

    public function __construct(UserRepository $userRepository)
    {
        $this->entity = $userRepository;
    }

    public function show()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $input = $request->only(['first_name', 'last_name']);
        $new_avatar = $this->entity->uploadImage($request, $image_name = 'avatar', $folder = 'avatar');
        if ($new_avatar != '') {
            $input['avatar'] = $new_avatar;
        }
        User::where('id', $request->id)->update($input);

        if (Auth::user()->role_id == User::TEACHER) {
            Teacher::where('user_id', $request->id)
                ->update($request->only(['expert', 'workplace']));

        } else if (Auth::user()->role_id == User::STUDENT) {
            Student::where('user_id', $request->id)
                ->update($request->only(['major', 'school']));
        }

        return redirect(route('profile.show'))->with('message', 'Update profile success');
    }

    public function enrolled()
    {
        $user = Auth::user();
        $enrolled = Enroll::where('student_id', $user->student->id)
            ->orderBy('created_at', 'desc')->get();

        return view('pages.enrolled_courses', compact('enrolled'));
    }

    public function recommend(Request $request)
    {
        $student = Auth::user()->student;
        $recommend_courses = (count($student->enrolled) == 0)
            ? $this->recommend_by_survey()
            : $this->recommend_by_enrollment();

        return view('pages.recommend', compact('recommend_courses'));
    }

    public function recommend_by_survey()
    {
        $student  = Auth::user()->student;
        $categories_id = $student->survey->pluck('courses_category_id')->toArray();
        $courses = Course::join('course_categories', 'courses.courses_category_id', 'course_categories.id')
            ->whereIn('course_categories.id', $categories_id)
            ->orderBy('courses.rate')
            ->select(['courses.*'])
            ->get();
        $recommend_courses = array();
        foreach ($courses as $c) {
            if (in_array($c->courses_category_id, $categories_id)) {
                array_push($recommend_courses, $c);
                $categories_id = array_diff($categories_id, [$c->courses_category_id]);
            }
        }

        return $recommend_courses;
    }

    public function recommend_by_enrollment()
    {
        $sim_csv_path = public_path("recommend/similar_matrix.csv");
        $file = fopen($sim_csv_path, 'r');
        $row = fgetcsv($file, 0, ',');

        $student = Auth::user()->student;
        $index_2_id = Course::pluck("id")->toArray();
        $id_2_index = array_flip($index_2_id);

        $courses = Course::pluck("name", "id")->toArray();  // array(["id" =>"name"])
        $enrolled = Enroll::join('courses', 'enrolls.course_id', '=', 'courses.id')
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
