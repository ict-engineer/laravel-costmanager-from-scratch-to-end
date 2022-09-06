<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('imgs/favicon_io/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('imgs/favicon_io/android-chrome-512x512.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('imgs/favicon_io/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imgs/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('imgs/favicon_io/favicon.png') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/vendors.min.css') }}">
    
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/vertical-menu-nav-dark-template/materialize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/vertical-menu-nav-dark-template/style.css') }}">
    
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/custom/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2-materialize.css') }}" type="text/css">
    <!-- END: Custom CSS-->
    <!-- loader wrapper -->
    <link rel="stylesheet" href='{{ asset("/css/preloader.css") }}'>
    <link rel="stylesheet" href="{{ asset('landing/css/linearicons.css') }}">
    <style>
        .home-area {
            min-height: 100%;
            display: flex;
            align-items: center;
        }
        .container-set {
            width: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        .wrap-set {
            width: 450px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        .overlay {
            position: relative;
            z-index: 1;
        }
        .set-btn {
            font-size:16px;
            font-weight: bold;
            width: 100%;
            height: 40px;
            border-radius: 20px;
            background: rgba(106, 198, 240, 1);
            background: -webkit-linear-gradient(right, rgba(72, 44, 191, 1),  rgba(106, 198, 240, 1));
            background: -o-linear-gradient(right, rgba(72, 44, 191, 1), rgba(106, 198, 240, 1));
            background: -moz-linear-gradient(right, rgba(72, 44, 191, 1), rgba(106, 198, 240, 1));
            background: linear-gradient(right, rgba(72, 44, 191, 1), rgba(106, 198, 240, 1));
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }
    </style>
    @yield('contentcss')
</head>

<body>
    
    <div class="limiter home-area overlay">
        <div class="container-set">
            @yield('content')
        </div>
    </div>

    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('app-assets/js/vendors.min.js') }}"></script>
    <!-- BEGIN THEME  JS-->
    <script src="{{ asset('app-assets/js/plugins.js') }}"></script>
    <script src="{{ asset('app-assets/js/search.js') }}"></script>
    <script src="{{ asset('app-assets/js/custom/custom-script.js') }}"></script>
    <!-- END THEME  JS-->
    <!-- Loader -->
    <script src='{{ asset("/js/preloader.js") }}'></script>
    <script src="{{ asset('landing/js/wow.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('app-assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    @yield('contentjs')
</body>
</html>