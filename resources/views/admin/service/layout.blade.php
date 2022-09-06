@extends('admin.layout')

@section('title')
services
@endsection

@section('admincss')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- flag -->
<link rel="stylesheet" href="{{ asset('bower_components/flag-icon-css/css/flag-icon.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@yield('servicecss')

@endsection

@section('admincontent')
@section('routename')
Services
@endsection
<section class="content">
    <div class="container-fluid">
        @yield('content')
    </div>
</section>
@endsection

@section('adminjs')
    @yield('servicejs')
@endsection