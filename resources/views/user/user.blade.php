<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Alex bondarev">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>TheQuoteBox</title>
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('imgs/favicon_io/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('imgs/favicon_io/android-chrome-512x512.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('imgs/favicon_io/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imgs/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('imgs/favicon_io/favicon.png') }}">
    <!-- Plugin-CSS -->
    <link rel="stylesheet" href="{{ asset('landing/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/animate.css') }}">
    <!-- Main-Stylesheets -->
    <link rel="stylesheet" href="{{ asset('landing/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/responsive.css') }}">
    <script src="{{ asset('landing/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .mainmenu-area ul.nav.navbar-nav li select {
            color: #ffffff;
            padding: 10px 2px;
            font-size: 1em;
            text-transform: capitalize;
            background: transparent;
            font-weight: 600;
            border-bottom: 2px solid transparent;
            margin: 0 15px;
            width: auto;
            border: 0px solid white;
            cursor: pointer;
        }

        .mainmenu-area ul.nav.navbar-nav li select option{
            font-size: 16px;
            line-height: 22px;
            display: block;
            padding: 14px 16px;
            color: #00bcd4;
            cursor: pointer;
        }

        .mainmenu-area ul.nav.navbar-nav li select:hover,
        .mainmenu-area ul.nav.navbar-nav li.active select {
        }
        @media only screen and (max-width: 767px)
        {
            .mainmenu-area #primary_menu ul.nav.navbar-nav li select {
                padding: 15px;
                border: none;
            }
        }
            
    </style>
    @yield('csscontent')
</head>

<body data-spy="scroll" data-target=".mainmenu-area">
    <!-- Preloader-content -->
    <div class="preloader">
        <span><i class="lnr lnr-sun"></i></span>
    </div>
    <!-- MainMenu-Area -->
    <nav class="mainmenu-area" data-spy="affix" data-offset-top="200">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary_menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><img src="{{ asset('landing/images/logo.png') }}" alt="Logo"></a>
            </div>
            <div class="collapse navbar-collapse" id="primary_menu">
                <ul class="nav navbar-nav mainmenu">
                    <li class="active"><a href="#home_page">Home</a></li>
                    <li><a href="#about_page">About</a></li>
                    <li><a href="#features_page">Features</a></li>
                    <li><a href="#gallery_page">Gallery</a></li>
                    <li><a href="#price_page">Pricing</a></li>
                    <li><a href="#questions_page">FAQ</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#contact_page">Contacts</a></li>
                    <li>
                    <div style="display:flex;justify-content:center;">
                        <select class="form-control changeLang">
                            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="es" {{ session()->get('locale') == 'es' ? 'selected' : '' }}>Español</option>
                        </select>
                    </div>
                    </li>
                </ul>
                
            </div>
            @if (Route::has('login'))
                @auth
                <div class="right-button signinpadding">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('messages.Sign Out') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                @else
                    <div class="right-button signinpadding">
                        <a href="{{ route('login') }}">{{ __('messages.Login') }} </a>
                        <a href="{{ route('register') }}">{{ __('messages.Sign Up') }} </a>
                    </div>
                @endif
            @endif
        </div>
    </nav>
    <!-- MainMenu-Area-End -->
    @yield('content')
    <!-- Subscribe-Form -->
    <div class="subscribe-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <div class="subscribe-form text-center">
                        <h3 class="blue-color">Subscribe for More Features</h3>
                        <div class="space-20"></div>
                        <form id="mc-form">
                            <input type="email" class="control" placeholder="Enter your email" required="required" id="mc-email">
                            <button class="bttn-white active" type="submit"><span class="lnr lnr-location"></span> Subscribe</button>
                            <label class="mt10" for="mc-email"></label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Subscribe-Form-Area -->
    <!-- Footer-Area -->
    <footer class="footer-area" id="contact_page">
        <div class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title text-center">
                            <h5 class="title">Contact US</h5>
                            <h3 class="dark-color">Find Us By Bellow Details</h3>
                            <div class="space-60"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-map-marker"></span>
                            </div>
                            <p>8-54 Paya Lebar Square, Mexico</p>
                        </div>
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-phone-handset"></span>
                            </div>
                            <p>+1234567890</p>
                        </div>
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-envelope"></span>
                            </div>
                            <p>admin@gmail.com
                            </p>
                        </div>
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div id="map"></div>
                    </div>
                    <!--
                    <div class="col-xs-12 col-sm-4">
                        <div class="footer-box">
                            <div class="box-icon">
                                <span class="lnr lnr-envelope"></span>
                            </div>
                            <p>admin@gmail.com
                            </p>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Footer-Bootom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-5">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            <span>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Admin <i class="lnr lnr-heart" aria-hidden="true"></i></span>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <div class="space-30 hidden visible-xs"></div>
                    </div>
                    <!-- <div class="col-xs-12 col-md-7">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Features</a></li>
                                <li><a href="#">Pricing</a></li>
                                <li><a href="#">Contacts</a></li>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Footer-Bootom-End -->
    </footer>
    <!-- Footer-Area-End -->
    <!--Vendor-JS-->
    
    <script src="{{ asset('landing/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('landing/js/vendor/jquery-ui.js') }}"></script>
    <script src="{{ asset('landing/js/vendor/bootstrap.min.js') }}"></script>
    <!--Plugin-JS-->
    <script src="{{ asset('landing/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('landing/js/contact-form.js') }}"></script>
    <script src="{{ asset('landing/js/ajaxchimp.js') }}"></script>
    <script src="{{ asset('landing/js/scrollUp.min.js') }}"></script>
    <script src="{{ asset('landing/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('landing/js/wow.min.js') }}"></script>
    <!--Main-active-JS-->
    <script src="{{ asset('landing/js/main.js') }}"></script>

    <!-- map -->
    <script src="{{ asset('landing/js/googlemap.js') }}"></script>
    <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqsYlbvunG8q26BV66NAVX3pGEl3lIgdI&libraries=places&callback=initMap">
    </script>
    <script>
        var url = "{{ route('changeLang') }}";
        $(".changeLang").change(function(){
            window.location.href = url + "?lang="+ $(this).val();
        });
    </script>
    @yield('jscontent')
</body>

</html>
