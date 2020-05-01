@extends('layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/course.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/course_responsive.css") }}">
<style>
    .instructor {
        padding: 0px;
    }

    .instructor_title {
        margin-left: 40px;
    }

    .cur_contents {
        margin-top: 0px;
    }

    .cur_item_content {
        margin-top: 10px;
    }
</style>
@endsection
@section('content')
<div class="header_padding" style="height: 120px;"></div>

<div class="intro">
    <img class="intro_background parallax-window" data-parallax="scroll" src="{{ asset('front-end/images/intro.jpg') }}"
        data-speed="0.8" alt="">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="intro_container d-flex flex-column align-items-start justify-content-end">
                    <div class="intro_content">
                        <div class="intro_price">Free</div>
                        <div class="rating_r rating_r_4 intro_rating"></div>
                        <div class="intro_title">{{ $course->name }}</div>
                        <div class="intro_meta">
                            <div class="intro_image">
                                <img src="{{ asset($course->teacher->avatar ? $course->teacher->avatar : \App\Models\Config::PLACEHOLDER_AVATAR) }}"
                                    alt="">
                            </div>
                            <div class="intro_instructors">
                                <a href="#">{{ $course->teacher->user->name }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="course">
    <div class="course_top"></div>
    <div class="container">
        <div class="row row-lg-eq-height">

            <!-- Panels -->
            <div class="col-lg-9">
                <div class="tab_panels">
                    <!-- Tabs -->
                    <div class="course_tabs_container">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="tabs nav nav-tabs d-flex flex-row align-items-center justify-content-start"
                                        role="tablist">
                                        <a class="nav-link active" data-toggle="tab" href="#description">description</a>
                                        <a class="nav-link" data-toggle="tab" href="#syllabus">Syllabus</a>
                                        <a class="nav-link" data-toggle="tab" href="#reviews">reviews</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <!-- Description -->
                        <div id="description" class="tab-pane tab_panel description active">
                            <div class="panel_title">About this course</div>
                            <div class="panel_text">
                                <p>{{ $course->overview }}</p>
                            </div>
                            <br>
                            <div class="panel_title">About teacher</div>
                            <div class="row instructors_row">

                                <!-- Instructor -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="instructor d-flex flex-row align-items-center justify-content-start">
                                        <div class="instructor_image">
                                            <div><img
                                                    src="{{ asset($course->teacher->avatar ? $course->teacher->avatar : \App\Models\Config::PLACEHOLDER_AVATAR) }}"
                                                    alt=""></div>
                                        </div>
                                        <div class="instructor_content">
                                            <div class="instructor_name"><a
                                                    href="instructors.html">{{ $course->teacher->user->name }}</a>
                                            </div>
                                            <div class="instructor_title">{{ $course->teacher->expert }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Curriculum -->
                        <div id="syllabus" class="tab-pane tab_panel curriculum fade">
                            <div class="curriculum_items">
                                @foreach($course->modules as $key => $module)
                                <div class="cur_item">
                                    <div
                                        class="cur_title_container d-flex flex-row align-items-start justify-content-start">
                                        <div class="cur_title">{{ $module->name }}</div>
                                        <div class="cur_num ml-auto"><i class="fa fa-flag-checkered"></i></div>
                                    </div>
                                    <div class="cur_item_content">
                                        <div class="cur_contents">
                                            <ul>
                                                <li>
                                                    <i class="fa fa-folder" aria-hidden="true"></i><span>1 video, 1
                                                        audio, 1 reading</span>
                                                    <ul>
                                                        @foreach($module->lectures as $lecture)
                                                        <li
                                                            class="d-flex flex-row align-items-center justify-content-start">
                                                            <i class="fa fa-file" aria-hidden="true"></i>
                                                            <span>Reading:
                                                                <a
                                                                    href="{{ route('lectures.show', ['id' => $lecture->id]) }}">{{ $lecture->name }}</a>
                                                            </span>
{{--                                                            <div class="cur_time ml-auto">--}}
{{--                                                                <i class="fa fa-clock-o" aria-hidden="true"></i><span>15--}}
{{--                                                                    minutes</span>--}}
{{--                                                            </div>--}}
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Reviews -->
                        <div id="reviews" class="tab-pane tab_panel reviews fade">
                            <div class="panel_title">Reviews</div>
                            <div class="panel_text">
                                <p>Lorem ipsum dolor sit amet, te eros consulatu pro, quem labores petentium no sea,
                                    atqui posidonium interpretaris pri eu. At soleat maiorum platonem vix, no mei
                                    case fierent. Primis quidam ancillae te mei.</p>
                            </div>
                            <div class="cur_ratings_container clearfix">
                                <div class="cur_rating d-flex flex-column align-items-center justify-content-center">
                                    <div class="cur_rating_num">4,5</div>
                                    <div class="rating_r rating_r_4 cur_stars"><i></i><i></i><i></i><i></i><i></i>
                                    </div>
                                    <div class="cur_rating_text">Rated 5 out of 3 Ratings</div>
                                </div>
                                <div
                                    class="cur_rating_progress d-flex flex-column align-items-center justify-content-center">
                                    <div
                                        class="cur_progress d-flex flex-row align-items-center justify-content-between">
                                        <span>5 stars</span>
                                        <div id="cur_pbar_1" class="cur_pbar" data-perc="0.80"></div>
                                    </div>
                                    <div
                                        class="cur_progress d-flex flex-row align-items-center justify-content-between">
                                        <span>5 stars</span>
                                        <div id="cur_pbar_2" class="cur_pbar" data-perc="0.20"></div>
                                    </div>
                                    <div
                                        class="cur_progress d-flex flex-row align-items-center justify-content-between">
                                        <span>5 stars</span>
                                        <div id="cur_pbar_3" class="cur_pbar" data-perc="0.0"></div>
                                    </div>
                                    <div
                                        class="cur_progress d-flex flex-row align-items-center justify-content-between">
                                        <span>5 stars</span>
                                        <div id="cur_pbar_4" class="cur_pbar" data-perc="0.0"></div>
                                    </div>
                                    <div
                                        class="cur_progress d-flex flex-row align-items-center justify-content-between">
                                        <span>5 stars</span>
                                        <div id="cur_pbar_5" class="cur_pbar" data-perc="0.0"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="cur_reviews">

                                <!-- Review -->
                                <div class="review">
                                    <div
                                        class="review_title_container d-flex flex-row align-items-start justify-content-start">
                                        <div
                                            class="review_title d-flex flex-row align-items-center justify-content-center">
                                            <div class="review_author_image">
                                                <div><img src="images/review_1.jpg" alt=""></div>
                                            </div>
                                            <div class="review_author">
                                                <div class="review_author_name"><a href="#">Sarah Parker</a></div>
                                                <div class="review_date">Sep 29, 2017 at 9:48 am</div>
                                            </div>
                                        </div>
                                        <div class="review_stars ml-auto">
                                            <div class="rating_r rating_r_4 review_rating">
                                                <i></i><i></i><i></i><i></i><i></i></div>
                                        </div>
                                    </div>
                                    <div class="review_text">
                                        <p>Nam egestas lorem ex, sit amet commodo tortor faucibus a. Suspendisse
                                            commodo, turpis a dapibus fermentum, turpis ipsum rhoncus massa, sed
                                            commodo nisi lectus id ipsum. Sed nec elit vehicula.</p>
                                    </div>
                                </div>

                                <!-- Review -->
                                <div class="review">
                                    <div
                                        class="review_title_container d-flex flex-row align-items-start justify-content-start">
                                        <div
                                            class="review_title d-flex flex-row align-items-center justify-content-center">
                                            <div class="review_author_image">
                                                <div><i class="fa fa-user" aria-hidden="true"></i></div>
                                            </div>
                                            <div class="review_author">
                                                <div class="review_author_name"><a href="#">Sarah Parker</a></div>
                                                <div class="review_date">Sep 29, 2017 at 9:48 am</div>
                                            </div>
                                        </div>
                                        <div class="review_stars ml-auto">
                                            <div class="rating_r rating_r_4 review_rating">
                                                <i></i><i></i><i></i><i></i><i></i></div>
                                        </div>
                                    </div>
                                    <div class="review_text">
                                        <p>Nam egestas lorem ex, sit amet commodo tortor faucibus a. Suspendisse
                                            commodo, turpis a dapibus fermentum, turpis ipsum rhoncus massa, sed
                                            commodo nisi lectus id ipsum. Sed nec elit vehicula.</p>
                                    </div>
                                </div>

                                <!-- Review -->
                                <div class="review">
                                    <div
                                        class="review_title_container d-flex flex-row align-items-start justify-content-start">
                                        <div
                                            class="review_title d-flex flex-row align-items-center justify-content-center">
                                            <div class="review_author_image">
                                                <div><i class="fa fa-user" aria-hidden="true"></i></div>
                                            </div>
                                            <div class="review_author">
                                                <div class="review_author_name"><a href="#">Sarah Parker</a></div>
                                                <div class="review_date">Sep 29, 2017 at 9:48 am</div>
                                            </div>
                                        </div>
                                        <div class="review_stars ml-auto">
                                            <div class="rating_r rating_r_4 review_rating">
                                                <i></i><i></i><i></i><i></i><i></i></div>
                                        </div>
                                    </div>
                                    <div class="review_text">
                                        <p>Nam egestas lorem ex, sit amet commodo tortor faucibus a. Suspendisse
                                            commodo, turpis a dapibus fermentum, turpis ipsum rhoncus massa, sed
                                            commodo nisi lectus id ipsum. Sed nec elit vehicula.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="sidebar_background"></div>
                    <div class="sidebar_top">
                        @if($has_enrolled)
                            @if(($module = $course->modules->first()) && $module->lectures->first())
                                <a style="background: gray" href="{{ route('lectures.show', [$module->lectures->first()->id]) }}">Continue</a>
                            @else
                                <a style="background: gray" href="{{ route('errors', [
                                                'error' => 'Course content error',
                                                'message' => 'Current course you seeing don\'t has any lectures',
                                            ]) }}">
                                    Continue</a>
                            @endif
                        @else
                        <a href="{{ route('courses.enroll', [$course->id]) }}">
                            enroll course
                        </a>
                        @endif

                    </div>
                    <div class="sidebar_content">

                        <!-- Features -->
                        <div class="sidebar_section features">
                            <div class="sidebar_title">Course Features</div>
                            <div class="features_content">
                                <ul class="features_list">

                                    <!-- Feature -->
                                    <li class="d-flex flex-row align-items-start justify-content-start">
                                        <div class="feature_title"><i class="fa fa-clock-o"
                                                aria-hidden="true"></i><span>Duration</span>
                                        </div>
                                        <div class="feature_text ml-auto">{{ count($course->modules) }} weeks</div>
                                    </li>

                                    <!-- Feature -->
                                    <li class="d-flex flex-row align-items-start justify-content-start">
                                        <div class="feature_title"><i class="fa fa-bell"
                                                aria-hidden="true"></i><span>Lectures</span>
                                        </div>
                                        <div class="feature_text ml-auto">{{ count($course->modules) }}</div>
                                    </li>

                                    <!-- Feature -->
                                    <li class="d-flex flex-row align-items-start justify-content-start">
                                        <div class="feature_title"><i class="fa fa-user"
                                                aria-hidden="true"></i><span>Enrolled</span>
                                        </div>
                                        <div class="feature_text ml-auto">{{ count($course->num_enrolls) }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- You may like -->
                        <div class="sidebar_section like">
                            <div class="sidebar_title">You may like</div>
                            <div class="like_items">

                                <!-- Like Item -->
                                <div class="like_item d-flex flex-row align-items-end justify-content-start">
                                    <div class="like_title_container">
                                        <div class="like_title">Vocabulary</div>
                                        <div class="like_subtitle">Spanish</div>
                                    </div>
                                    <div class="like_price ml-auto">Free</div>
                                </div>
                                <!-- Like Item -->
                                <div class="like_item d-flex flex-row align-items-end justify-content-start">
                                    <div class="like_title_container">
                                        <div class="like_title">Vocabulary</div>
                                        <div class="like_subtitle">Spanish</div>
                                    </div>
                                    <div class="like_price ml-auto">Free</div>
                                </div>
                                <!-- Like Item -->
                                <div class="like_item d-flex flex-row align-items-end justify-content-start">
                                    <div class="like_title_container">
                                        <div class="like_title">Vocabulary</div>
                                        <div class="like_subtitle">Spanish</div>
                                    </div>
                                    <div class="like_price ml-auto">Free</div>
                                </div>
                                <!-- Like Item -->
                                <div class="like_item d-flex flex-row align-items-end justify-content-start">
                                    <div class="like_title_container">
                                        <div class="like_title">Vocabulary</div>
                                        <div class="like_subtitle">Spanish</div>
                                    </div>
                                    <div class="like_price ml-auto">Free</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
