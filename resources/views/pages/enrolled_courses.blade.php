@extends('layouts.master')

@section('content')
    <div class="header_padding" style="height: 120px;"></div>
    <div class="auth">
        <div class="container">
            <div class="row auth_row justify-content-center">
                <div class="col-md-8">
                    @foreach($enrolled as $enroll)
                        <div class="course_body">
                            <div class="course_title">
                                <a href="#"> {{ $enroll->course->name }}</a>
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary e-btn pull-right">
                                    Go to course
                                </a>
                            </div>
                            <br>
                            <div class="course_info">
                                <ul>
                                    <li><a href="#"><b> {{ $enroll->course->teacher->user->name }}</b></a></li>
                                    <li><a href="#">English</a></li>
                                </ul>
                            </div>
                            <div class="course_text">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce enim nulla.</p>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
