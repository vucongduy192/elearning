@extends('layouts.master')

@section('content')
<div class="header_padding" style="height: 20px;"></div>
<div class="auth" style="padding-bottom: 60px;">
    <div class="container-fluid">
        <div class="row auth_row">
            <div class="col-md-3">
                <div class="course_body">
                    <div class="course_title">
                        <a href="#">{{ $lecture->module->course->name }}</a>
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
                        <div class="col-md-10 lecture_title">
                            <span class="cur_item_title_before">{{ $key + 1 }}</span>
                            {{ $module->name }}
                        </div>
                        <div class="col-md-2 pull-right">
                            <form action="#" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group template-checkbox">
                                    <input class="process" type="checkbox"
                                           name="module{{ $module->id }}" id="module{{ $module->id }}"
                                           {{ in_array($module->id, $module_processed) ? 'checked' : ''}}
                                           data-course_id="{{ $lecture->module->course->id }}" data-module_id="{{ $module->id }}"
                                           data-student_id="{{ \Illuminate\Support\Facades\Auth::user()->student->id }}">
                                    <label for="module{{ $module->id }}"></label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="cur_item_content">
                        <div class="cur_contents sidebar_cur_contents">
                            <ul>
                                @foreach($module->lectures as $l)
                                <?php $urls = explode('/', Request::url()); ?>
                                <li>
                                    <?php $filetype = explode(".", $l->slide); ?>
                                    @if(end($filetype) == 'pdf')
                                        <i class="fa fa-file" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-video-camera" aria-hidden="true"></i>
                                    @endif
                                    <span>
                                        <a class="lecture_link"
                                            style="font-weight: {{ end($urls)==$l->id ? 'bold' : '' }}"
                                            href="{{ route('lectures.show', ['id' => $l->id]) }}">
                                            {{ $l->name }}
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
@section('scripts')
    <script>
        $('.process').click(function () {
            console.log();
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
    </script>
@endsection
