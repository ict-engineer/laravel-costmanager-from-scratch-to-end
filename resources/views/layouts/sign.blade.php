<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>@yield('title')</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('imgs/favicon_io/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('imgs/favicon_io/android-chrome-512x512.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('imgs/favicon_io/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imgs/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('imgs/favicon_io/favicon.png') }}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('signup/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('signup/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('signup/fonts/iconic/css/material-design-iconic-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('signup/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('signup/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('signup/vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('signup/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('signup/vendor/daterangepicker/daterangepicker.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('signup/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('signup/css/main.css') }}">
<!--===============================================================================================-->
	<!-- loader wrapper -->
	<link rel="stylesheet" href='{{ asset("/css/preloader.css") }}'>
	<link rel="stylesheet" href="{{ asset('landing/css/linearicons.css') }}">
	@yield('contentcss')
</head>
<body>
	<!-- Preloader-content -->
    <div class="preloader">
        <span><i class="lnr lnr-sun"></i></span>
    </div>
	
	<!-- loader end -->
	<div class="limiter home-area overlay">
		@yield('content')
	</div>
	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
    <script src="{{ asset('signup/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('signup/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('signup/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('signup/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('signup/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('signup/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('signup/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('signup/vendor/countdowntime/countdowntime.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('signup/js/main.js') }}"></script>
	<!-- google login -->
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<!-- Loader -->
	<script src='{{ asset("/js/preloader.js") }}'></script>
	<script src="{{ asset('landing/js/wow.min.js') }}"></script>
	@yield('jscontent')
</body>
</html>