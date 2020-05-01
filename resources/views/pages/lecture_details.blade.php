@extends('layouts.master')

@section('content')
<div class="header_padding" style="height: 20px;"></div>
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
                                <?php $urls = explode('/', Request::url()); ?>
                                <li>
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span>
                                        <a class="lecture_link"
                                            style="font-weight: {{ end($urls)==$lecture->id ? 'bold' : '' }}"
                                            href="{{ route('lectures.show', ['id' => $lecture->id]) }}">
                                            Reading: {{ $lecture->name }}
                                        </a>
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
                <div class="course_footer d-flex flex-row align-items-center justify-content-start">
                    <div class="course_students"><i class="fa fa-user" aria-hidden="true"></i><span>86</span></div>
                    <div class="course_rating ml-auto"><i class="fa fa-star" aria-hidden="true"></i><span>4.5</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
