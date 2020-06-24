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
                    <div class="card-header">{{ __('Xác thực email') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Mail xác thực đã được gửi đến địa chỉ mail của bạn') }}
                            </div>
                        @endif

                        {{ __('Trước khi bắt đầu, vui lòng kiểm tra email và xác thực') }}
                        {{ __('Nếu bạn không nhận được email') }}, <a href="{{ route('verification.resend') }}">{{ __('Bấm vào đây để gửi lại') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
