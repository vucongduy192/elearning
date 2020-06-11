@extends('layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/main_styles.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/responsive.css") }}">
<style>
    .courses_row {
        margin-top: 20px;
    }
</style>
@endsection
@section('content')
<div class="header_padding" style="height: 120px;"></div>
<div class="courses">
    <div class="courses_background"></div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="section_title">Recommend courses from your survey</h3>
            </div>
        </div>
        @if (count($recommend_by_survey) == 0)
            <div class="course_text">
                Not found any courses conform with your survey
            </div>
        @endif
        <div class="row courses_row">
            <!-- Course -->
            @foreach($recommend_by_survey as $course)
            <div class="col-md-4 course_col">
                <div class="course">
                    <div class="course_image"><img
                            src="{{ asset($course->thumbnail ? $course->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL) }}"
                            alt=""></div>
                    <div class="course_body">
                        <div class="course_title">
                            <a href="{{ route('courses.show', ['id' => $course->id]) }}">{{ mb_substr($course->name, 0, 21, "utf-8") }}

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
                        <div class="course_students">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>{{ $course->enrolls }}</span>
                        </div>
                        <div class="course_rating ml-auto">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span>{{ (count($course->reviews) != 0) ? round($course->reviews->pluck('rating')->avg(), 0) : '0' }}</span>
                        </div>
                        @if($course->price == 0)
                        <div class="course_mark course_free trans_200"><a href="#">Free</a></div>
                        @else
                        <div class="course_mark trans_200"><a href="#">${{$course->price}}</a></div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div style="clear: both; height: 60px;"></div>
        @if($recommend_by_enroll)
        <div class="row">
            <div class="col">
                <h3 class="section_title">You may like</h3>
            </div>
        </div>
        @endif
        <div class="row courses_row">
            <!-- Course -->
            @foreach($recommend_by_enroll as $course)
            <div class="col-md-4 course_col">
                <div class="course">
                    <div class="course_image"><img
                            src="{{ asset($course->thumbnail ? $course->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL) }}"
                            alt=""></div>
                    <div class="course_body">
                        <div class="course_title">
                            <a href="{{ route('courses.show', ['id' => $course->id]) }}">{{ mb_substr($course->name, 0, 21, "utf-8") }}

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
                        <div class="course_students">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>{{ $course->enrolls }}</span>
                        </div>
                        <div class="course_rating ml-auto">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span>{{ (count($course->reviews) != 0) ? round($course->reviews->pluck('rating')->avg(), 0) : '0' }}</span>
                        </div>
                        @if($course->price == 0)
                        <div class="course_mark course_free trans_200"><a href="#">Free</a></div>
                        @else
                        <div class="course_mark trans_200"><a href="#">${{$course->price}}</a></div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection