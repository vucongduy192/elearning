<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\CourseRepository;
use App\Repositories\ProcessRepository;
use App\Repositories\UserRepository;
use App\Repositories\EnrollRepository;
use App\Repositories\SurveyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    protected $entity, $enroll, $survey, $course, $process;

    public function __construct(UserRepository $userRepository, EnrollRepository $enrollRepository,
                                SurveyRepository $surveyRepository, CourseRepository $courseRepository,
                                ProcessRepository $processRepository)
    {
        $this->entity = $userRepository;
        $this->enroll = $enrollRepository;
        $this->survey = $surveyRepository;
        $this->course = $courseRepository;
        $this->process = $processRepository;
    }

    /**
     * Show current user profile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    /**
     * User after login, change profile
     * @param ProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProfileRequest $request)
    {
        $input = $request->only(['first_name', 'last_name']);
        $new_avatar = $this->entity->uploadImage($request, $image_name = 'avatar', $folder = 'avatar');
        if ($new_avatar != '') {
            $input['avatar'] = $new_avatar;
        }
        $this->entity->update($request->id, $input);

        if (Auth::user()->role_id == User::TEACHER) {
            Teacher::where('user_id', $request->id)
                ->update($request->only(['expert', 'workplace']));

        } else if (Auth::user()->role_id == User::STUDENT) {
            Student::where('user_id', $request->id)
                ->update($request->only(['major', 'school']));
        }

        return redirect(route('profile.show'))->with('message', 'Update profile success');
    }

    /**
     * Show history enrolled of current user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function enrolled_page(Request $request)
    {
        return view('pages.enrolled_courses');
    }

    public function enrolled_courses(Request $request)
    {
        $user = Auth::user();
        $enrolled = $this->process->getEnrolledWithProcess($user->student->id, $request->completed);
        return $this->response([
            'html' => View::make('components.enrolled_list')->with(['enrolled' => $enrolled])->render()
        ]);
    }

    /**
     * Recommend courses by user profile:
     *      + Using survey results if user has no enrollment data
     *      + Using enrollment data
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recommend(Request $request)
    {
        $student = Auth::user()->student;
        $recommend_by_survey = $this->survey->recommend();
        $recommend_by_enroll = (count($student->enrolled) != 0) ? $this->enroll->recommend()['top_courses'] : [];

        return view('pages.recommend', compact('recommend_by_survey', 'recommend_by_enroll'));
    }
}
