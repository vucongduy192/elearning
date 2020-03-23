<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>E-learning</title>

        <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/bootstrap4/bootstrap.min.css') }}">
        <link href="{{ asset('assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/OwlCarousel2-2.2.1/animate.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/main_styles.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/responsive.css') }}">

        <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('assets/styles/bootstrap4/popper.js') }}"></script>
        <script src="{{ asset('assets/styles/bootstrap4/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
        <script src="{{ asset('assets/plugins/easing/easing.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
    </head>

    <body>
    <div id="app">
        </div>
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>
