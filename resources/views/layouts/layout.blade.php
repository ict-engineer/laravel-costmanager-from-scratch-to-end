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
    <!-- END: Custom CSS-->
    <!-- loader wrapper -->
    <link rel="stylesheet" href='{{ asset("/css/preloader.css") }}'>
    <link rel="stylesheet" href="{{ asset('landing/css/linearicons.css') }}">

    <style>
      #profile-dropdown {
        max-width: 190px;
        overflow: hidden;
      }
    </style>
    @yield('contentcss')
</head>
<body class="hold-transition vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">

    <!-- Preloader-content -->
    <!-- <div class="preloader">
        <span><i class="lnr lnr-sun"></i></span>
    </div> -->
    <div class="progress">
        <div class="indeterminate"></div>
    </div>
    <!-- BEGIN: Header-->
    
    <header class="page-topbar" id="header">
      <div class="navbar navbar-fixed"> 
        <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-light-yellow gradient-shadow">
          <div class="nav-wrapper">
          
            <!-- <div class="header-search-wrapper hide-on-med-and-down"><i class="material-icons">search</i>
              <input class="header-search-input z-depth-2" type="text" name="Search" placeholder="Search Everything" data-search="template-list">
              <ul class="search-list collection display-none"></ul>
            </div> -->
            <ul class="navbar-list right">
            
            @if(session()->get('locale') == 'es')
                <li class="dropdown-language"><a class="waves-effect waves-block waves-light translation-button" href="#" data-target="translation-dropdown">Español</a></li>
            @else
                <li class="dropdown-language"><a class="waves-effect waves-block waves-light translation-button" href="#" data-target="translation-dropdown">English</a></li>  
            @endif
              <!-- <li class="hide-on-large-only search-input-wrapper"><a class="waves-effect waves-block waves-light search-button" style='height:64px;' href="javascript:void(0);"><i class="material-icons">search</i></a></li> -->
              @if(Auth::user()->image=='')
                <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="{{ asset('imgs/user.png') }}" id="userAvatar"><i></i></span></a></li>
              @else
                <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown">
                    <span class="avatar-status avatar-online"><img src="{{ url(Auth::user()->image) }}" id="userAvatar"><i></i></span>
                </a></li>
              @endif
              <li style="display:flex;align-items:center;"><div class="usernameheader">{{ Auth::user()->name }}</div></li>
              <li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
            </ul>
            <!-- translation-button-->
            <ul class="dropdown-content" id="translation-dropdown">
              <li class="dropdown-item"><a class="grey-text text-darken-1 changeLang" data-language="en"> English</a></li>
              <li class="dropdown-item"><a class="grey-text text-darken-1 changeLang" data-language="es"> Español</a></li>
            </ul>
            <!-- profile-dropdown-->
            <ul class="dropdown-content" id="profile-dropdown">
              <li><a class="grey-text text-darken-1 clientUserItem" href="{{ route('user.profile') }}"><i class="material-icons">person_outline</i> {{ __('messages.User Settings') }}</a></li>
              @if(!(Auth::user()->hasPermissionTo('Employee Sales') || Auth::user()->hasPermissionTo('Employee Administrative') || Session::get('type') == 'Provider'))
              <li><a class="grey-text text-darken-1 clientUserItem" href="{{ route('user.purchaseplan') }}"><i class="material-icons">card_membership</i> {{ __('messages.Membership') }}</a></li>
              <li><a class="grey-text text-darken-1 clientUserItem" href="{{ route('user.payments') }}"><i class="material-icons">attach_money</i> {{ __('messages.Payment') }}</a></li>
              @endif
              <li><a class="grey-text text-darken-1 clientUserItem" href="page-faq.html"><i class="material-icons">help_outline</i> {{ __('messages.Help') }}</a></li>
              <li class="divider"></li>
              <li>
                    <a class="grey-text text-darken-1 clientUserItem" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        if (typeof isChanged === 'undefined') {
                            document.getElementById('logout-form').submit();
                        }"><i class="material-icons">keyboard_tab</i> 
                        {{ __('messages.Sign Out') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
              </li>
            </ul>
          </div>
          <nav class="display-none search-sm">
            <div class="nav-wrapper">
              <form id="navbarForm">
                <div class="input-field search-input-sm">
                  <input class="search-box-sm mb-0" type="search" required="" id="search" placeholder="Search Everything" data-search="template-list">
                  <label class="label-icon" for="search"><i class="material-icons search-sm-icon">search</i></label><i class="material-icons search-sm-close">close</i>
                  <ul class="search-list collection search-list-sm display-none"></ul>
                </div>
              </form>
            </div>
          </nav>
        </nav>
      </div>
    </header>
    <!-- END: Header-->

    <!-- BEGIN: SideNav-->
    
    <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light navbar-full sidenav-active-rounded">
    
      <div class="brand-sidebar">
        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="/"><img class="hide-on-med-and-down" style="height:42px;margin-top: -13px; width: 190px;" src="{{ asset('imgs/TheQuoteBox_logo.png') }}" alt="TheQuoteBox Logo"/><img class="hide-on-med-and-down collapse_icon" style="height:42px;margin-top:-14px;" src="{{ asset('imgs/favicon_io/favicon.ico') }}" alt="TheQuoteBox Logo"/><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
      </div>
      <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
      
        @if(Session::get('type') == 'Provider')
          <li class="bold"><a class="mt-3 waves-effect waves-cyan " id="sideprovidershops" href="/user/providershops"><i class="material-icons">shopping_cart</i><span class="menu-title" data-i18n="{{ __('messages.Shops') }}">{{ __('messages.Shops') }}</span></a>
          </li>
          <li class="bold"><a class="waves-effect waves-cyan " id="sideprovidermaterials" href="/user/providermaterials"><i class="material-icons">thumb_up</i><span class="menu-title" data-i18n="{{ __('messages.Materials') }}">{{ __('messages.Materials') }}</span></a>
          </li>
        @endif
        @if(Session::get('type') == 'Client')
          <li class="bold"><a class="mt-3 waves-effect waves-cyan clientSideItem" id="sideclientquotes" href="/user/clientquotes"><i class="material-icons">account_balance</i><span class="menu-title" data-i18n="{{ __('messages.Quotes') }}">{{ __('messages.Quotes') }}</span></a>
          </li>
          @if(Session::get('isMexican') != 'yes')
          <li class="bold"><a class="waves-effect waves-cyan clientSideItem" id="sideclientinvoices" href="/user/clientinvoices"><i class="material-icons">assignment</i><span class="menu-title" data-i18n="{{ __('messages.Invoices') }}">{{ __('messages.Invoices') }}</span></a>
          </li>
          @endif
          <li class="bold"><a class="waves-effect waves-cyan clientSideItem" id="sideclientclients" href="/user/clientclients"><i class="material-icons">supervisor_account</i><span class="menu-title" data-i18n="{{ __('messages.Clients') }}">{{ __('messages.Clients') }}</span></a>
          </li>
          <li class="bold"><a class="waves-effect waves-cyan clientSideItem" id="sideclientprojects" href="/user/clientprojects"><i class="material-icons">apps</i><span class="menu-title" data-i18n="{{ __('messages.Projects') }}">{{ __('messages.Projects') }}</span></a>
          </li>
          <li class="bold"><a class="waves-effect waves-cyan clientSideItem" id="sideclientmaterials" href="/user/clientmaterials"><i class="material-icons">thumb_up</i><span class="menu-title" data-i18n="{{ __('messages.My Materials') }}">{{ __('messages.My Materials') }}</span></a>
          </li>
          <li class="bold"><a class="waves-effect waves-cyan clientSideItem" id="sideconsult_materials" href="/user/consult_materials"><i class="material-icons">search</i><span class="menu-title" data-i18n="{{ __('messages.Consult Materials') }}">{{ __('messages.Consult Materials') }}</span></a>
          </li>
          <li class="bold"><a class="waves-effect waves-cyan clientSideItem" id="sideclientservices" href="/user/clientservices"><i class="material-icons">local_laundry_service</i><span class="menu-title" data-i18n="{{ __('messages.Services') }}">{{ __('messages.Services') }}</span></a>
          </li>
          @if(!Auth::user()->hasPermissionTo('Employee Sales'))
          <li class="navigation-header"><a class="navigation-header-text">{{ __('messages.Set Up') }} </a><i class="navigation-header-icon material-icons">more_horiz</i>
          </li>
          <li class="bold"><a class="waves-effect waves-cyan clientSideItem" id="sideclientemployees" href="/user/clientemployees"><i class="material-icons">verified_user</i><span class="menu-title" data-i18n="{{ __('messages.Employees') }}">{{ __('messages.Employees') }}</span></a>
          </li>
          <li class="bold"><a class="waves-effect waves-cyan clientSideItem" id="sideclientfixedexpenses" href="/user/clientfixedexpenses"><i class="material-icons">monetization_on</i><span data-i18n="{{ __('messages.Fixed Expenses') }}" class="menu-title" >{{ __('messages.Fixed Expenses') }}</span></a>
          </li>
          @endif
        @endif
      </ul>
      <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
    </aside>
    <!-- END: SideNav-->

    <div id="main">
        <div class="row">
            <div class="content-wrapper-before blue-grey lighten-5"></div>
            <div class="breadcrumbs-inline pt-3 pb-1" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s10 m6 l6 breadcrumbs-left">
                            @yield('pagetitle')
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="container">
                        @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <footer class="page-footer footer footer-static footer-dark gradient-45deg-light-yellow gradient-shadow navbar-border navbar-shadow">
      <div class="footer-copyright">
        <div class="container"><span>&copy; 2020 {{ __('messages.All rights reserved') }}.</span><span class="right hide-on-small-only"></span></div>
      </div>
    </footer>
    
    <script>
        var isCollapse = '{!! Session::get("isCollapse") !!}';
    </script>
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
    <!-- set active current side menu -->
    <script>
        var texts = window.location.href.split('/');
        if(texts.length > 4)
        {
          var tmps = texts[4].split('?');
          tmps[0] = tmps[0].replace('#', '');
          $('#side' + tmps[0]).addClass('active');
        }
        // document.addEventListener('DOMContentLoaded', function() {
        //     console.log($( document ).width());
        //     if($( document ).width() > 992 && $( document ).width() < 1281)
        //     {
        //         console.log($('.logo-wrapper .navbar-toggler'));
        //         $('.sidenav-main').removeClass('nav-lock');
        //         $('.sidenav-main').addClass('nav-collapsed');
        //     }
        // });
        // $('.logo-wrapper .navbar-toggler')
        

        $("body").on("click",".logo-wrapper .navbar-toggler",function(){
            var value = "";
            if($(this).children().text() == 'radio_button_checked')
            {
                value = 'no';
            }
            else{
                value = 'yes';
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: {key:'isCollapse', value:value},
                url: "{{ route('setSessionValue') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        var url = "{{ route('changeLang') }}";
        $("body").on("click",".changeLang",function(){
            console.log($(this).attr('data-language'));
            window.location.href = url + "?lang="+ $(this).attr('data-language');
        });
    </script>
    @yield('contentjs')
</body>
</html>
