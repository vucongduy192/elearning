@extends('layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/main_styles.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/responsive.css") }}">
@endsection
@section('content')
<div class="home">
    <div class="home_background" style="background-image: url({{ asset('front-end/images/index_background.jpg') }});">
    </div>
    <div class="home_content">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h1 class="home_title">E-Learning Easily</h1>
                    <div class="home_button trans_200"><a href="{{ route('courses.index') }}">get started</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="courses">
    <div class="courses_background"></div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section_title text-center">Popular Online Courses</h2>
            </div>
        </div>
        <div class="row courses_row">
            <!-- Course -->
            @foreach($popular_courses as $course)
            <div class="col-lg-4 course_col">
                <div class="course">
                    <div class="course_image"><img
                            src="{{ asset($course->thumbnail ? $course->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL) }}"
                            alt=""></div>
                    <div class="course_body">
                        <div class="course_title">
                            <a href="{{ route('courses.show', ['id' => $course->id ]) }}">
                                {{ mb_substr($course->name, 0, 21, "utf-8") }}
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
                        <div class="course_students"><i class="fa fa-user"
                                aria-hidden="true"></i><span>{{ $course->enrolls }}</span></div>
                        <div class="course_rating ml-auto"><i class="fa fa-star"
                                aria-hidden="true"></i><span>{{ ($course->reviews) ? $course->reviews->pluck('rating')->avg() : 0 }}</span>
                        </div>
                        <div class="course_mark course_free trans_200"><a href="#">Free</a></div>
                    </div>
                </div>
            </div>
            @endforeach
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
            @foreach($best_teachers as $teacher)
            <!-- Instructor -->
            <div class="col-lg-4 instructor_col">
                <div class="instructor text-center">
                    <div class="instructor_image_container">
                        <div class="instructor_image"><img
                                src="{{ asset($teacher->user->avatar ? $teacher->user->avatar : \App\Models\Config::PLACEHOLDER_AVATAR) }}"
                                alt=""></div>
                    </div>

                    <div class="instructor_name">
                        <a href="{{ route('professors.show', ['id' => $teacher->id]) }}">
                            {{ $teacher->user->name }}
                        </a>
                    </div>

                    <div class="instructor_title">{{ $teacher->expert }}</div>
                    <div class="instructor_text">
                        <p>{{ $teacher->workplace }}</p>
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

@guest
<div class="register">
    <div class="container">
        <div class="row">

            <!-- Register Form -->

            <div class="col-lg-6">
                <div class="register_form_container">
                    <div class="register_form_title">Courses For Free</div>
                    <br>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" autocomplete="name">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary e-btn">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Register Timer -->

            <div class="col-lg-6">
                <div class="register_timer_container">
                    <div class="register_timer_title">Register Now</div>
                    <div class="register_timer_text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce enim nulla, mollis eu metus
                            in, sagittis fringilla tortor.</p>
                    </div>
                    <div class="timer_container">
                        <ul class="timer_list">
                            <li>
                                <div id="day" class="timer_num">00</div>
                                <div class="timer_ss">days</div>
                            </li>
                            <li>
                                <div id="hour" class="timer_num">00</div>
                                <div class="timer_ss">hours</div>
                            </li>
                            <li>
                                <div id="minute" class="timer_num">00</div>
                                <div class="timer_ss">minutes</div>
                            </li>
                            <li>
                                <div id="second" class="timer_num">00</div>
                                <div class="timer_ss">seconds</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endguest

<div class="events">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section_title text-center">New Blogs</h2>
            </div>
        </div>
        <div class="row events_row">
            @foreach($newest_blogs as $blog)
            <div class="col-lg-4 event_col">
                <div class="event">
                    <div class="event_image">
                        <img src="{{ $blog->thumbnail ? $blog->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL }}"
                            alt="">
                    </div>
                    <div class="event_body d-flex flex-row align-items-center justify-content-start">
                        <div class="event_title">
                            <a
                                href="{{ route('blogs.show', ['id' => $blog->id]) }}">{{ substr($blog->title, 0, 20) . '...' }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection