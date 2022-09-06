@extends('admin.layout')

@section('title')
Terms and Conditions
@endsection

@section('admincss')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

@yield('termcss')

@endsection

@section('admincontent')
@section('routename')
Terms and Conditions
@endsection
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        @yield('content')
    </div>
</section>
@endsection

@section('adminjs')
    @yield('termjs')
@endsection