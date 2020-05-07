@extends('layouts.master')

@section('content')
    <div class="header_padding"></div>
    <div class="auth">
        <div class="container">
            <div class="row auth_row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Survey interested category</div>

                        <div class="card-body">
                            @if (session('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('survey.update') }}" enctype="multipart/form-data" class="survey-form">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <div class="row">
                                    @foreach($survey as $category)
                                        <div class="form-group template-checkbox col-md-6">
                                            <input type="checkbox" name="category_id[]" id="{{ $category->name }}" {{ $category->interest != null ? "checked" : "" }}
                                                value="{{ $category->id }}">
                                            <label for="{{ $category->name }}">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
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
