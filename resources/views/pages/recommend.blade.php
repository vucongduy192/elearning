@extends('layouts.master')

@section('content')
    <div class="header_padding" style="height: 120px;"></div>
    <div class="courses">
        <div class="courses_background"></div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="section_title text-center">Recommend courses for you</h2>
                </div>
            </div>
            <div class="row courses_row">
                <!-- Course -->
                @foreach($recommend_courses as $course)
                    <div class="col-lg-4 course_col">
                        <div class="course">
                            <div class="course_image"><img src="{{ asset($course->thumbnail ? $course->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL) }}" alt=""></div>
                            <div class="course_body">
                                <div class="course_title">
                                    <a href="course.html">{{ mb_substr($course->name, 0, 21, "utf-8") }}

                                    </a>
                                </div>
                                <div class="course_info">
                                    <ul>
                                        <li><a href="instructors.html">{{ $course->teacher->user->name }}</a></li>
                                        <li><a href="#">English</a></li>
                                    </ul>
                                </div>
                                <div class="course_text">
                                    <p>{{ $course->overview }}</p>
                                </div>
                            </div>
                            <div class="course_footer d-flex flex-row align-items-center justify-content-start">
                                <div class="course_students"><i class="fa fa-user" aria-hidden="true"></i><span>10</span></div>
                                <div class="course_rating ml-auto"><i class="fa fa-star" aria-hidden="true"></i><span>4,5</span></div>
                                <div class="course_mark course_free trans_200"><a href="#">Free</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
