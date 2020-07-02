@extends('layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/main_styles.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/responsive.css") }}">
@endsection
@section('content')
<div class="header_padding" style="height: 120px;"></div>
<div class="auth">
    <div class="container">
        <div class="row auth_row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Hồ sơ</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">

                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" name="email" disabled class="form-control"
                                        value="{{ $user->email }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="first_name" class="col-md-2 col-form-label text-md-right">Họ của bạn</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                        class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                        value="{{ old('first_name') ? old('first_name') : $user->first_name}}">

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-2 col-form-label text-md-right">Tên của bạn</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                        value="{{ old('last_name') ? old('last_name') : $user->last_name}}">

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-2 col-form-label text-md-right">Ảnh đại
                                    diện</label>

                                <div class="col-md-6">
                                    <input type="file" id="avatar" name="avatar"
                                        class="form-control preview-upload-image" />
                                    <img src="{{ $user->avatar ? $user->avatar : \App\Models\Config::PLACEHOLDER_AVATAR }}"
                                        class="preview-avatar" />
                                </div>
                            </div>
                            @if($user->role_id == \App\Models\User::STUDENT)
                            <div class="form-group row">
                                <label for="school" class="col-md-2 col-form-label text-md-right">School</label>

                                <div class="col-md-6">
                                    <input id="school" type="text"
                                        class="form-control @error('school') is-invalid @enderror" name="school"
                                        value="{{ old('school') ? old('school') : $user->student->school }}">

                                    @error('school')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="school" class="col-md-2 col-form-label text-md-right">Major</label>

                                <div class="col-md-6">
                                    <input id="major" type="text"
                                        class="form-control @error('major') is-invalid @enderror" name="major"
                                        value="{{ old('major') ? old('major') : $user->student->major }}">

                                    @error('major')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @elseif($user->role_id == \App\Models\User::TEACHER)
                            <div class="form-group row">
                                <label for="expert" class="col-md-2 col-form-label text-md-right">Expert</label>

                                <div class="col-md-6">
                                    <input id="expert" type="text"
                                        class="form-control @error('expert') is-invalid @enderror" name="expert"
                                        value="{{ old('expert') ? old('expert') : $user->teacher->expert }}">

                                    @error('expert')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="expert" class="col-md-2 col-form-label text-md-right">Workplace</label>

                                <div class="col-md-6">
                                    <input id="workplace" type="text"
                                        class="form-control @error('expert') is-invalid @enderror" name="workplace"
                                        value="{{ old('workplace') ? old('workplace') : $user->teacher->workplace }}">

                                    @error('workplace')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @endif
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-2">
                                    Cập nhật sở thích của bạn. Làm <a href="{{ route('survey.show') }}"> khảo sát </a>
                                    ngay.
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-2">
                                    <button type="submit" class="btn btn-primary e-btn">
                                        Lưu
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.preview-avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#avatar").change(function() {
        readURL(this);
    });

    @if (session('message'))
        toastr.success("{{ session('message') }}");
    @endif
</script>
@endsection