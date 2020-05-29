@extends('layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/instructors.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/instructors_responsive.css") }}">
@endsection
@section('content')
<div class="header_padding" style="height: 500px;"></div>

<div class="video">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="video_content">
                    <div class="video_container_outer">
                        <div class="video_overlay d-flex flex-column align-items-start justify-content-center">
                            <div>Be</div>
                            <div>The Best</div>
                            <div>Teacher</div>
                        </div>
                        <div class="video_container">
                            <video id="vid1" class="video-js vjs-default-skin" controls width="100%" height="100%"
                                data-setup='{ "poster": "images/video.jpg", "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "https://youtu.be/IV3ueyrp5M4"}], "youtube": { "iv_load_policy": 1 } }'>
                            </video>
                        </div>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user() == null)
                    <div class="register_button">
                        <a href="{{ route('register') }}">register</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="instructors">
    <div class="instructors_background"
        style="background-image: url({{ asset('front-end/images/instructors_background.png') }})"></div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section_title text-center">The Best Tutors in Town</h2>
            </div>
        </div>
        <div class="row instructors_row">
            @foreach($best_teachers as $professor)
            <!-- Instructor -->
            <div class="col-lg-4 instructor_col">
                <div class="instructor text-center">
                    <div class="instructor_image_container">
                        <div class="instructor_image"><img
                                src="{{ asset($professor->user->avatar ? $professor->user->avatar : \App\Models\Config::PLACEHOLDER_AVATAR) }}"
                                alt=""></div>
                    </div>
                    <div class="instructor_name"><a href="{{ route('professors.show', ['id' => $professor->id]) }}">
                            {{ $professor->user->name }}</a></div>
                    <div class="instructor_title">{{ $professor->expert }}</div>
                    <div class="instructor_text">
                        <p>{{ $professor->workplace }}</p>
                    </div>
                    <div class="instructor_social">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

<div class="teachers">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section_title text-center">Top Teachers in Every Field</h2>
            </div>
        </div>
        <div class="row teachers_row">
            @foreach($best_teacher_in_fields as $category => $professor)
                @if(!empty($professor))
                <div class="col-lg-4 col-md-6">
                    <div class="teacher d-flex flex-row align-items-center justify-content-start">
                        <div class="teacher_image">
                            <div><img
                                    src="{{ asset($professor->user->avatar ? $professor->user->avatar : \App\Models\Config::PLACEHOLDER_AVATAR) }}"
                                    alt=""></div>
                        </div>
                        <div class="teacher_content">
                            <div class="teacher_name">
                                <a href="{{ route('professors.show', ['id' => $professor->id]) }}">
                                    {{ $professor->user->name }}
                                </a>
                            </div>
                            <div class="teacher_title">{{ $professor->expert }}</div>
                            <div class="teacher_title">{{ $category }}</div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection