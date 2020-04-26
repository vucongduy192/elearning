@extends('layouts.master')

@section('content')
    <div class="header_padding" style="height: 120px;"></div>
    <div class="auth" style="min-height: 550px;">
        <div class="container">
            <div class="row auth_row justify-content-center">
                <div class="col-md-8">
                    @if(count($enrolled) == 0)
                        <div class="card">
                            <div class="card-body">
                                You don't have any enrollment history data. Make survey now
                            </div>
                        </div>
                    @endif
                    @foreach($enrolled as $enroll)
                        <div class="course_body">
                            <div class="course_title">
                                <a href="#"> {{ $enroll->course->name }}</a>
                            </div>
                            <div>
                                <a href="{{ route('courses.show', ['id' => $enroll->course->id]) }}" class="btn btn-primary e-btn pull-right">
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
