@extends('admin.layout')

@section('title')
Materials
@endsection

@section('admincss')
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- select -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @yield('materialcss')
@endsection

@section('admincontent')
@section('routename')
Materials
@endsection
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        @yield('content')
    </div>
</section>
@endsection

@section('adminjs')

    @yield('materialjs')
@endsection