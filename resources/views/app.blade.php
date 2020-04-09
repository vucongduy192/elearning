<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>E-learning</title>
        <link href="{{ mix('front-end/css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
        </div>
        <script type="text/javascript" src="{{ mix('front-end/js/app.js') }}"></script>
    </body>
</html>
