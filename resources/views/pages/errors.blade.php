@extends('layouts.master')

@section('content')
    <div class="header_padding"></div>
    <div class="auth">
        <div class="container">
            <div class="row auth_row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ $error }}</div>

                        <div class="card-body">
                            {{ $message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
