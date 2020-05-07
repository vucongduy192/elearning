@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/courses.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/courses_responsive.css") }}">
    <style>
        .header_padding {
            height: 150px;
        }
        .form-search .form-group {
            margin-bottom: 0px;
        }
    </style>
@endsection
@section('content')
    <div class="header_padding"></div>
    <div class="courses">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    @if (count($courses) == 0)
                        <div class="alert alert-success" role="alert">
                            Không tìm thấy khóa học!
                        </div>
                    @endif
                    <form method="POST" action="{{ route('courses.search') }}" class="form-search">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter course name">
                            </div>
                            <div class="col-md-3 form-group">
                                <select class="form-control" name="courses_category_id" id="">
                                    <option value="" {{ !old('courses_category_id') ? "selected" : "" }}>All categories</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ old('courses_category_id') == $c->id ? "selected" : "" }}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary e-btn">
                                    Search
                                </button>
                            </div>
                        <?php
                            session()->forget('_old_input');
                            ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row courses_row">
                @foreach($courses as $course)
                    <div class="col-lg-4 course_col">
                        <div class="course">
                            <div class="course_image"><img src="{{ $course->teacher->avatar ? $course->teacher->avatar : \App\Models\Config::PLACEHOLDER_THUMBNAIL }}" alt=""></div>
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
                                <div class="course_students"><i class="fa fa-user" aria-hidden="true"></i><span>{{ $course->enrolls }}</span></div>
                                <div class="course_rating ml-auto"><i class="fa fa-star" aria-hidden="true"></i><span>{{ $course->rate }}</span>
                                </div>
                                <div class="course_mark course_free trans_200"><a href="#">Free</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pull-right">
                {{ $courses->links('components.pagination') }}
            </div>
        </div>
    </div>
@endsection

