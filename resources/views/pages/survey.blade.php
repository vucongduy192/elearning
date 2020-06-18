@extends('layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/main_styles.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/responsive.css") }}">
<style>
    .carousel-item {
        min-height: 320px;
    }

    .carousel-control-next-icon:after {
        content: '>';
        font-size: 55px;
        color: rgba(0, 0, 0, 0.45);
    }

    .carousel-control-prev-icon:after {
        content: '<';
        font-size: 55px;
        color: rgba(0, 0, 0, 0.45);
    }

    .carousel-inner {
        width: 70%;
        margin-left: 15%;
    }

    ol.carousel-indicators li,
    ol.carousel-indicators li.active {
        border: 0;
        margin: 8px;
        height: 10px;
        width: 10px;
    }

    ol.carousel-indicators li {
        background: rgba(0, 0, 0, 0.45);
    }

    ol.carousel-indicators li.active {
        background: #2e21df;
    }

    .dot {
        position: absolute;
        transform: scale(1.5);
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
                        <div id="survey-carousel" class="carousel slide" data-interval="false">
                            <ol class="carousel-indicators">
                                <li data-target="#survey-carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#survey-carousel" data-slide-to="1"></li>
                                {{-- <li data-target="#survey-carousel" data-slide-to="2"></li> --}}
                            </ol>
                            <div class="carousel-inner">
                                <form method="POST" action="{{ route('survey.update') }}" enctype="multipart/form-data"
                                    class="survey-form">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="level">Level</label>
                                                <select class="form-control" name="level" id="">
                                                    <option value=""
                                                        {{ empty($surveyRank['ranks']->level) ? "selected" : ""}}>
                                                        All levels</option>
                                                    <option value="{{ App\Models\Course::EASY }}"
                                                        {{ $surveyRank['ranks'] && $surveyRank['ranks']->level == 1 ? "selected" : ""}}>
                                                        Easy</option>
                                                    <option value="{{ App\Models\Course::MEDIUM }}"
                                                        {{ $surveyRank['ranks'] && $surveyRank['ranks']->level == 2 ? "selected" : ""}}>
                                                        Medium</option>
                                                    <option value="{{ App\Models\Course::HARD }}"
                                                        {{ $surveyRank['ranks'] && $surveyRank['ranks']->level == 3 ? "selected" : ""}}>
                                                        Hard</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="duration_id">Duration</label>
                                                <select class="form-control" name="duration_id" id="">
                                                    <option value=""
                                                        {{ empty($surveyRank['ranks']->duration_id) ? "selected" : ""}}>
                                                        All durations
                                                    </option>
                                                    @foreach($surveyRank['durations'] as $duration)
                                                    <option value="{{ $duration->id }}"
                                                        {{ $surveyRank['ranks'] && $duration->id == $surveyRank['ranks']->duration_id ? "selected" : ""}}>
                                                        {{ $duration->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 20px;">
                                            <div class="col-sm-12">
                                                <label for="partner_id">From</label>
                                                <select class="form-control" name="partner_id" id="">
                                                    <option value=""
                                                        {{  empty($surveyRank['ranks']->partner_id) ? "selected" : ""}}>
                                                        All partners
                                                    </option>
                                                    @foreach($surveyRank['partners'] as $partner)
                                                    <option value="{{ $partner->id }}"
                                                        {{ $surveyRank['ranks'] && $partner->id == $surveyRank["ranks"]->partner_id ? "selected" : ""}}>
                                                        {{ $partner->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="form-group template-checkbox col-md-6">
                                                <input type="checkbox" name="free" id="free"
                                                    {{ $surveyRank["ranks"] && $surveyRank['ranks']->free == 1 ? "checked" : "" }}
                                                    value="1">
                                                <label for="free">Only free courses</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
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
                                    <div class="row">
                                        <div class="form-group">
                                            @if (session('message'))
                                            <a href="{{ route('profile.recommend') }}" style="margin-left: 20px;">
                                                See your recommend now !</a>
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
                            <a class="carousel-control-prev" href="#survey-carousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#survey-carousel" role="button" data-slide="next">
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