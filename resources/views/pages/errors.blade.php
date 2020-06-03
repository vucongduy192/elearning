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
                        <div class="card-header">{{ $error }}</div>
                        
                        <div class="card-body">
                            {!! $message !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
