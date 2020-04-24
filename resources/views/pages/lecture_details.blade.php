@extends('layouts.master')

@section('content')
<div class="header_padding" style="height: 100px;"></div>
<div class="auth" style="padding-bottom: 60px;">
    <div class="container-fluid">
        <div class="row auth_row">
            <div class="col-md-3">
                <div class="course_body">
                    <div class="course_title">
                        <a href="#">{{ $lecture->course->name }}</a>
                    </div>
                    <div class="course_info">
                        <ul>
                            <li><a href="instructors.html">{{ $lecture->course->teacher->user->name }}</a></li>
                            <li><a href="#">English</a></li>
                        </ul>
                    </div>
                    <div class="course_text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce enim nulla.</p>
                    </div>
                </div>
                <br>
                <div class="course_body">
                    @foreach($allLectures as $key => $lecture)
                        <div class="row">
                            <p class="lecture_title">
                                {{ $lecture->name }}
                            </p>
                        </div>
                        <div class="cur_item_content">
                            <div class="cur_contents">
                                <ul>
                                    <li>
                                        <i class="fa fa-video-camera" aria-hidden="true"></i>
                                        <span>
                                            <a class="lecture_link" href="{{ route('lectures.show', ['id' => $lecture->id]) }}">Video</a>
                                        </span>
                                    </li>
                                    <li>
                                        <i class="fa fa-file" aria-hidden="true"></i>
                                        <span>
                                            <a class="lecture_link" href="{{ route('lectures.show', ['id' => $lecture->id]) }}">Reading</a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
            <div class="col-md-9">
                <object type="application/pdf" data="{{ $lecture->slide }}">
                    <embed type="application/pdf">
                </object>
            </div>
        </div>
    </div>
</div>
@endsection
