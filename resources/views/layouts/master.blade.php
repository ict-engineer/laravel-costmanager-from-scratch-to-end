<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>
  @yield('title')
  </title>

  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('imgs/favicon_io/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('imgs/favicon_io/android-chrome-512x512.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('imgs/favicon_io/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imgs/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('imgs/favicon_io/favicon.png') }}">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href='{{ asset("/bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css") }}'>
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href='{{ asset("/bower_components/admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}'>
  <!-- Theme style -->
  <link rel="stylesheet" href='{{ asset("/bower_components/admin-lte/dist/css/adminlte.min.css") }}'>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!--- button css --->
  <link rel="stylesheet" href='{{ asset("/css/button.css") }}'>
  <!-- loader wrapper -->
  <link rel="stylesheet" href='{{ asset("/css/loader-wrapper.css") }}'>
  @yield('csscontent')
</head>

<body class="hold-transition sidebar-mini">
 <!-- loader start -->
 <div id="loader" class="loader-wrapper">
    <div class=" bar">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    </div>
</div>
    <!-- loader end -->
<div class="wrapper">
    <!-- Navbar -->
  <nav class="main-header navbar-fixed navbar navbar-expand gradient-45deg-indigo-purple" >
    <!-- Left navbar links -->
    <ul class="navbar-nav" style="font-size:22px;">
      <li class="nav-item">
        <a  style="color:white;" class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a  style="color:white;" href="/" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a  style="color:white;" href="/dashboard" class="nav-link">Admin Dashboard</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      <li class="dropdown user user-menu" style="margin:10px;">
          <a href="#" class="dropdown-toggle"  style="color:white;"  data-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('imgs/avatar1.png') }}" class="user-image" alt="User Image">
            <span class="hidden-xs" style="color:white;">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="{{ asset('imgs/avatar1.png') }}" class="img-circle" alt="User Image">

              <p>
              {{ Auth::user()->name }}
              </p>
            </li>
            <!-- Menu Body -->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-right" style="display:flex;justify-content:center;">
              <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                  Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
              </div>
            </li>
          </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link"  style="color:white;" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  
    @yield('bodycontent')
    
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2020 </strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.1
        </div>
    </footer>
</div>
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src='{{ asset("/bower_components/admin-lte/plugins/jquery/jquery.min.js") }}'>
    </script>
    <!-- Bootstrap -->
    <script src='{{ asset("/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js") }}'></script>
    <!-- overlayScrollbars -->
    <script src='{{ asset("/bower_components/admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}'></script>
    <!-- AdminLTE App -->
    <script src='{{ asset("/bower_components/admin-lte/dist/js/adminlte.js") }}'></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src='{{ asset("/bower_components/admin-lte/dist/js/demo.js") }}'></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src='{{ asset("/bower_components/admin-lte/plugins/jquery-mousewheel/jquery.mousewheel.js") }}'></script>
    <script src='{{ asset("/bower_components/admin-lte/plugins/raphael/raphael.min.js") }}'></script>
    <script src='{{ asset("/bower_components/admin-lte/plugins/jquery-mapael/jquery.mapael.min.js") }}'></script>
    <script src='{{ asset("/bower_components/admin-lte/plugins/jquery-mapael/maps/usa_states.min.js") }}'></script>
    <!-- ChartJS -->
    <script src='{{ asset("/bower_components/admin-lte/plugins/chart.js/Chart.min.js") }}'></script>

    <!-- PAGE SCRIPTS -->
    <script src='{{ asset("/bower_components/admin-lte/dist/js/pages/dashboard2.js") }}'></script>
    
    <!-- Loader -->
    <script src='{{ asset("/js/loader-wrapper.js") }}'></script>

    <!-- set active current side menu -->
    <script>
        var texts = window.location.href.split('/');
        if(texts.length == 4)
        {
          var tmps = texts[3].split('?');
          $('#side' + tmps[0]).addClass('active');
        }
    </script>
    @yield('jscontent')
</body>
</html>
