<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" value="{{ csrf_token() }}">
        <title>Admin</title>
        <link href="{{ asset('back-end/css/lib.min.css') }}" rel="stylesheet">
        <link href="{{ asset('back-end/css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div id="app"></div>

        <script src="{{ asset('back-end/js/app.js') }}"></script>
        <script src="{{ asset('back-end/js/lib.min.js') }}"></script>
    </body>
</html>