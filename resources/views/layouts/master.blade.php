<!DOCTYPE html>
<html lang="en">
<head>
    <title>E Learning</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Lingua project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/bootstrap4/bootstrap.min.css") }}">
    <link href="{{ asset("front-end/plugins/font-awesome-4.7.0/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/plugins/OwlCarousel2-2.2.1/owl.carousel.css") }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset("front-end/plugins/OwlCarousel2-2.2.1/owl.theme.default.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/plugins/OwlCarousel2-2.2.1/animate.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/main_styles.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/responsive.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("front-end/styles/custom.css") }}">
</head>
<body>
@yield('styles')

<div class="super_container">
    @component('components.header')
    @endcomponent
    <!-- *** HEADER END *** -->

    @component('components.navbar')
    @endcomponent
    <!-- *** NAVBAR END *** -->

    <!-- *** CONTENT ***
    _________________________________________________________ -->
    @yield('content')

    <!-- *** FOOTER ***
_________________________________________________________ -->
    @component('components.footer')
    @endcomponent
</div>
<!-- *** FOOTER END *** -->

<script src="{{ asset("front-end/js/jquery-3.2.1.min.js") }}"></script>
<script src="{{ asset("front-end/styles/bootstrap4/popper.js") }}"></script>
<script src="{{ asset("front-end/styles/bootstrap4/bootstrap.min.js") }}"></script>
<script src="{{ asset("front-end/plugins/OwlCarousel2-2.2.1/owl.carousel.js") }}"></script>
<script src="{{ asset("front-end/plugins/easing/easing.js") }}"></script>
<script src="{{ asset("front-end/js/custom.js") }}"></script>

@yield('scripts')
</body>
</html>
