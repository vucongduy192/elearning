@extends('layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/main_styles.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/responsive.css") }}">
@endsection
@section('content')
<div class="header_padding"></div>
<div class="auth">
    <div class="container">
        <div class="row auth_row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Survey interested category</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('survey.update') }}" enctype="multipart/form-data"
                            class="survey-form">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <div class="row">
                                @foreach($survey as $category)
                                <div class="form-group template-checkbox col-md-6">
                                    <input type="checkbox" name="category_id[]" id="{{ $category->name }}"
                                        {{ $category->interest != null ? "checked" : "" }} value="{{ $category->id }}">
                                    <label for="{{ $category->name }}">{{ $category->name }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    @if (session('message'))
                                        <a href="{{ route('profile.recommend') }}" style="margin-left: 20px;">See your recommend now !</a>
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