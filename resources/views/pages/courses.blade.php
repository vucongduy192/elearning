@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/courses.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/courses_responsive.css") }}">
    <style>
        .header_padding {
            height: 130px;
        }
        .form-search .form-group {
            margin-bottom: 0px;
        }
    </style>
@endsection
@section('content')
    <div class="header_padding"></div>
    <div class="courses" style="min-height: 700px;">
        <div class="container">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-body">
                    <form method="POST" action="{{ route('courses.search') }}" class="search-form">
                        @csrf
                        <div class="row" style="margin-bottom: -20px;">
                            <div class="col-md-5 form-group">
                                <input id="name" type="text" value="{{ $header_search_name }}" class="form-control" name="name" placeholder="Course name">
                            </div>

                            <div class="col-md-3 form-group">
                                <input id="teacher" type="text" class="form-control" name="teacher" placeholder="Professor name">
                            </div>

                            <div class="col-md-3 form-group">
                                <select class="form-control" name="courses_category_id" id="">
                                    <option value="" {{ !old('courses_category_id') ? "selected" : "" }}>All categories</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ old('courses_category_id') == $c->id ? "selected" : "" }}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary e-btn search-btn">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="courses_list" style="min-height: 295px;">

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function filter_courses(url="{{ route('courses.search') }}") {
            $.ajax({
                url: url,
                method: "POST",
                dataType: 'json',
                data: $('.search-form').serialize(),
                beforeSend: function () {
                    $('.courses_list').waitMe({effect: 'bounce', text: '', bg: 'rgba(255,255,255,0.7)', color: '#000'});
                },
                success: function (data) {
                    $('.courses_list').waitMe('hide').html(data.html);
                }
            });
        }
        $(document).ready(function () {
            filter_courses();

            $('.search-btn').click(function (e) {
                e.preventDefault();
                filter_courses();
            });

            $('body').on('click', '.pagination li',  function (e) {
                e.preventDefault();
                filter_courses(url=$(this).find("a").attr('href'));
            });
        })
    </script>
@endsection
