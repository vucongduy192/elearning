@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/course.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/course_responsive.css") }}">
    <style>
        .cur_contents {
            margin-top: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="header_padding" style="height: 120px;"></div>

    <div class="intro">
        <img class="intro_background parallax-window" data-parallax="scroll"
             src="{{ asset('front-end/images/intro.jpg') }}"
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
                                    <img
                                        src="{{ asset($course->teacher->avatar ? $course->teacher->avatar : \App\Models\Config::PLACEHOLDER_AVATAR) }}"
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
                                        <div
                                            class="tabs nav nav-tabs d-flex flex-row align-items-center justify-content-start"
                                            role="tablist">
                                            <a class="nav-link active" data-toggle="tab" href="#description">description</a>
                                            <a class="nav-link" data-toggle="tab" href="#syllabus">syllabus</a>
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
                                        <div
                                            class="instructor d-flex flex-row align-items-center justify-content-start">
                                            <div class="instructor_image">
                                                <div><img
                                                        src="{{ asset($course->teacher->avatar ? $course->teacher->avatar : \App\Models\Config::PLACEHOLDER_AVATAR) }}"
                                                        alt=""></div>
                                            </div>
                                            <div class="instructor_content">
                                                <div class="instructor_name"><a
                                                        href="#">{{ $course->teacher->user->name }}</a>
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
                                            <div class="cur_item_content">
                                                <span class="cur_item_title_before">{{ $key + 1 }}</span>
                                                <div class="pull-right">
                                                    <div class="form-group template-checkbox">
                                                        @if($has_enrolled)
                                                        <input class="process" type="checkbox"
                                                               name="module{{ $module->id }}"
                                                               id="module{{ $module->id }}"
                                                               {{ in_array($module->id, $module_processed) ? 'checked' : ''}}
                                                               data-course_id="{{ $course->id }}"
                                                               data-module_id="{{ $module->id }}"
                                                               data-student_id="{{ \Illuminate\Support\Facades\Auth::user()->student->id }}">
                                                        <label for="module{{ $module->id }}"></label>
                                                        @else
                                                            <input class="process" type="checkbox" id="module-none">
                                                            <label for="module-none"></label>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="cur_item_title">{{ $module->name }}</div>
                                                <div class="cur_item_text">
                                                    <p>{{ $module->overview }}</p>
                                                </div>

                                                <div class="cur_contents">
                                                    <ul>
                                                        <li>
                                                            <ul>
                                                                @foreach($module->lectures as $lecture)
                                                                    <li class="d-flex flex-row align-items-center justify-content-start">
                                                                        <?php $filetype = explode(".", $lecture->slide); ?>
                                                                        @if(end($filetype) == 'pdf')
                                                                            <i class="fa fa-file"
                                                                               aria-hidden="true"></i>
                                                                        @else
                                                                            <i class="fa fa-video-camera"
                                                                               aria-hidden="true"></i>
                                                                        @endif
                                                                        <span>
                                                                    <a class="lecture_link"
                                                                       href="{{ route('lectures.show', ['id' => $lecture->id]) }}">
                                                                        {{ $lecture->name }}
                                                                    </a>
                                                                </span>
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
                                <div class="cur_reviews" style="margin-top:10px;">
                                </div>
                                @if($has_enrolled)
                                <div class="review new-review">
                                    <form method="POST" action="#" class="review-form">
                                        @csrf

                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <input type="hidden" name="student_id" value="{{ \Illuminate\Support\Facades\Auth::user()->student->id }}">
                                        <div class="form-group row">
                                            <textarea id="content" class="form-control @error('content') is-invalid @enderror"
                                                      name="content" value="{{ old('content') }}" rows="3"></textarea>

                                            <span class="invalid-feedback content-error" role="alert" style="display: inline-block">
                                                <strong></strong>
                                            </span>
                                        </div>

                                        <div class="form-group pull-right">
{{--                                            <button type="button" class="btn btn-primary e-btn-cancel ca">Cancel</button>--}}
                                            <button type="button" class="btn btn-primary e-btn review-submit">Save</button>
                                        </div>

                                        <div class="rating">
                                            <i class="fa fa-star" data-rate="1"></i>
                                            <i class="fa fa-star" data-rate="2"></i>
                                            <i class="fa fa-star" data-rate="3"></i>
                                            <i class="fa fa-star" data-rate="4"></i>
                                            <i class="fa fa-star" data-rate="5"></i>
                                            <input type="hidden" id="rating-count" name="rating" value="0">
                                            <span class="invalid-feedback rating-error" role="alert" style="display: inline">
                                                <strong></strong>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                @endif
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
                                    <a style="background: gray"
                                       href="{{ route('lectures.show', [$module->lectures->first()->id]) }}">Continue</a>
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
                                @foreach($recommend_courses as $r_c)
                                    <!-- Like Item -->
                                        <div class="like_item d-flex flex-row align-items-end justify-content-start">
                                            <div class="like_title_container">
                                                <div class="like_title">{{ $r_c->name }}</div>
                                                <div class="like_subtitle">{{ $r_c->teacher->user->name }}</div>
                                            </div>
                                            <div class="like_price ml-auto">Free</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // ------------------------------------------------------
        // ------------ Student update process course -----------
        @if (session('message'))
        toastr.success("{{ session('message') }}");
        @endif

        var has_enrolled = {{ json_encode($has_enrolled) }};
        function wanring_msg(selector, msg) {
            $(selector).click(function (e) {
                if (has_enrolled == false) {
                    e.preventDefault();
                    toastr.warning(msg);
                }
            });
        }
        wanring_msg('.lecture_link', 'Enroll course before access any lectures');
        wanring_msg('.process', 'Enroll course before update any process');

        $('.process').click(function () {
            var url = "{{ route('processes.store') }}", method = "POST";
            if (!$(this).is(':checked')) {
                url = "{{ route('processes.destroy') }}";
                method = "DELETE";
            }
            $.ajax({
                url: url,
                method: method,
                data: {
                    _token: "{{ csrf_token() }}",
                    course_id: $(this).data("course_id"),
                    module_id: $(this).data("module_id"),
                    student_id: $(this).data("student_id"),
                },
                success: function (data) {
                    toastr.success(data.message);
                }
            });
        });

        // ---------------------------------------------
        // ------------ Fetch student reviews -----------
        function fetch_reviews (url="{{ route('reviews.index', ['course_id' => $course->id]) }}") {
            $.ajax({
                url: url,
                success: function (data) {
                    $('.cur_reviews').html(data.html);
                }
            });
        }

        $(document).ready(function () {
            fetch_reviews();

            $('body').on('click', '.pagination li',  function (e) {
                e.preventDefault();
                fetch_reviews(url=$(this).find("a").attr('href'));
            });
        });

        // ----------------------------------------------
        // ------------ Student rating course -----------
        $('.rating i')
            .on('click', function(){
                $('#rating-count').val($(this).data('rate'));
                $(this).parent().find('i:lt(' + ($(this).index() + 1) + ')').addClass('selected');
            })
            .on('mouseover', function(){
                    $(this).parent().children('.rating i').each(function(e){
                    $(this).removeClass('selected');
                });
                $(this).parent().find('i:lt(' + ($(this).index() + 1) + ')').addClass('hover');
            })
            .on('mouseout', function(){
                $(this).parent().children('.rating i').each(function(e){
                    $(this).removeClass('hover');
                });
            });

        $('.review-submit').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('reviews.store') }}",
                method: "POST",
                dataType: 'json',
                data: $('.review-form').serialize(),
                beforeSend: function () {
                    $('.review-form').waitMe({effect: 'bounce', text: '', bg: 'rgba(255,255,255,0.7)', color: '#000'});
                },
                success: function (data) {
                    toastr.success(data.message);
                    $('.review-form').waitMe('hide');
                    $('.review-form')[0].reset();
                    $('.rating i').removeClass('selected');
                    fetch_reviews();
                },
                error: function (reject) {
                    if( reject.status === 422 ) {
                        $('.review-form').waitMe('hide');
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function (key, val) {
                            $("." + key + "-error strong").text(val[0]);
                        });
                        toastr.error(errors.message);
                    }
                }
            });
        });
    </script>
@endsection
