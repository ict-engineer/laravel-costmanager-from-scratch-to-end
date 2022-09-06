@extends('admin.layout')

@section('title')
Providers
@endsection

@section('admincss')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<!--- country seletor --->
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

@yield('providercss')

@endsection

@section('admincontent')
@section('routename')
Providers
@endsection

<section class="content">
    <div class="container-fluid">
        @yield('content')
    </div>
</section>
@endsection

@section('adminjs')
<!-- <script src="http://code.jquery.com/jquery-1.12.4.min.js"></script> -->
    @yield('providerjs')
@endsection