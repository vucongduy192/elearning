@extends('layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/main_styles.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/responsive.css") }}">
<style>
    label {
        color: rgba(0, 0, 0, 0.45);
    }

    .carousel-item {
        min-height: 320px;
    }

    .carousel-control-next-icon:after {
        content: '>';
        font-size: 55px;
        color: rgba(0, 0, 0, 0.45);
        margin-left: -30px;
    }

    .carousel-control-prev-icon:after {
        content: '<';
        font-size: 55px;
        color: rgba(0, 0, 0, 0.45);
    }

    .carousel-inner {
        width: 70%;
        margin-left: 20%;
    }
</style>
@endsection
@section('content')
<div class="header_padding"></div>
<div class="auth">
    <div class="container">
        <div class="row auth_row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Survey interested category</div>

                    <div class="card-body">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <form method="POST" action="{{ route('survey.update') }}" enctype="multipart/form-data"
                                    class="survey-form">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            @foreach($survey as $category)
                                            <div class="form-group template-checkbox col-md-6">
                                                <input type="checkbox" name="category_id[]" id="{{ $category->name }}"
                                                    {{ $category->interest != null ? "checked" : "" }}
                                                    value="{{ $category->id }}">
                                                <label for="{{ $category->name }}">{{ $category->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="row">
                                            @foreach($surveyTeacher as $teacher)
                                            <div class="form-group template-checkbox col-md-6">
                                                <input type="checkbox" name="teacher_id[]" id="{{ $teacher->name }}"
                                                    {{ $teacher->interest != null ? "checked" : "" }}
                                                    value="{{ $teacher->id }}">
                                                <label for="{{ $teacher->name }}">{{ $teacher->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="row">
                                            <select class="form-control" name="courses_category_id" id="">
                                                <option value="" {{ !old('courses_category_id') ? "selected" : "" }}>All
                                                    categories</option>
                                                @foreach($categories as $c)
                                                <option value="{{ $c->id }}"
                                                    {{ old('courses_category_id') == $c->id ? "selected" : "" }}>
                                                    {{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            @if (session('message'))
                                            <a href="{{ route('profile.recommend') }}" style="margin-left: 20px;">See
                                                your
                                                recommend now !</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary e-btn">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
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
    @if (session('message'))
        toastr.success("{{ session('message') }}");
        @endif
</script>
@endsection