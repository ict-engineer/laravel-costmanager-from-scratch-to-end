<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/favicon/apple-touch-icon-152x152.png') }}">
    <link rel="shortcut icon" type="image/ico" href="{{ asset('landing/images/favicon1.png') }}"/>
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
    <link rel="stylesheet" href="{{ asset('custom_components/function_table/css/main.css') }}" type="text/css">
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
        .invoice-subtotal-title-preview {
            width: 110px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .bold-weight-font {
            font-weight: 900;
        }
        .big-font {
            font-size: 18px;
        }
        .invoice-subtotal-title {
            display: flex;
            align-items: center;
            text-align: right;
        }
        .print-area {
            color: black;
            font-weight: 300;
        }

        #quoteLogoImage {
            max-height: 100px;
            margin-bottom: 2px;
        }

        #quoteMainArea {
            box-shadow: 0 18px 36px 0px rgba(0, 0, 0, 0.32);
        }

        @media only screen and (max-width: 768px) {
            #bigArea {
                width: 100% !important;
                padding:0px !important;
                margin:0px !important;
            }
        }
    </style>
</head>

<body>
    
    <div class="limiter display-flex justify-content-center">
            <div class="pt-3 pb-3 pl-2 pr-2" style="width: 80%; max-width: 1000px;" id="bigArea">
                <div class="card" id="quoteMainArea">
                    <div class="card-content print-area">
                    
                    </div>
                </div>
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
    <script>
        var content = `{!! $content !!}`;
        $('.print-area').html(content);
        
    </script>
</body>
</html>
