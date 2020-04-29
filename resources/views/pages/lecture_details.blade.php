@extends('layouts.master')

@section('content')
<div class="header_padding" style="height: 100px;"></div>
<div class="auth" style="padding-bottom: 60px;">
    <div class="container-fluid">
        <div class="row auth_row">
            <div class="col-md-3">
                <div class="course_body">
                    <div class="course_title">
                        <a href="#">Course: {{ $lecture->module->course->name }}</a>
                    </div>
                    <div class="course_info">
                        <ul>
                            <li><a href="instructors.html">{{ $lecture->module->course->teacher->user->name }}</a></li>
                            <li><a href="#">English</a></li>
                        </ul>
                    </div>
                    <div class="course_text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce enim nulla.</p>
                    </div>
                </div>
                <br>
                <div class="course_body">
                    @foreach($allModules as $key => $module)
                    <div class="row">
                        <p class="lecture_title">
                            {{ $module->name }}
                        </p>
                    </div>
                    <div class="cur_item_content">
                        <div class="cur_contents">
                            <ul>
                                @foreach($module->lectures as $lecture)
                                <li>
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span>
                                        <a class="lecture_link"
                                            href="{{ route('lectures.show', ['id' => $lecture->id]) }}">Reading: {{ $lecture->name }}</a>
                                    </span>
                                </li>
                                @endforeach
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
