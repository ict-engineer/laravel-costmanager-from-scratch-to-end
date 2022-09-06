@extends('layouts.master')

@section('title')
Admin Dashboard
@endsection
@section('csscontent')
    @yield('admincss')
@endsection

@section('bodycontent')

<!-- Sidebar -->
@include('admin.sidebar')
<div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">@yield('routename')</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">@yield('routename')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@yield('admincontent')
</div>

@endsection

@section('jscontent')
    @yield('adminjs')
@endsection