@extends('admin.shop.layout')
   
@section('shopcss')
<!-- select -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<style>
    /* Set the size of the div element that contains the map */
  #map {
    height: 400px;  /* The height is 400 pixels */
    width: 100%;  /* The width is the width of the web page */
    }
</style>
<!-- flag -->
<link rel="stylesheet" href="{{ asset('bower_components/flag-icon-css/css/flag-icon.min.css') }}">
@endsection
@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
    <!-- jquery validation -->
  
    <div class="card card-primary">
        <div class="card-header">
            <h1 class="card-title">Create Shop</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('shops.store') }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            <input type="hidden" name="lat" id="lat" value="{{ old( 'lat', 0) }}">
            <input type="hidden" name="lng" id="lng" value="{{ old( 'lng', 0) }}">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="providerlist">Provider</label>
                <div class="col-sm-8">
                  <select class="form-control select2" style="width: 100%;height: calc(2.25rem + 2px);" name="providerlist" id="providerlist"></select>
                </div>
            </div>
              
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="exampleInputName1">Name</label>
                <div class="col-sm-8">
                <input type="text" name="name" id="name" class="form-control" id="exampleInputName1" placeholder="Name" value="{{ old( 'name') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="addline1">Address Line1</label>
                <div class="col-sm-8">
                <input type="text" name="addline1" class="form-control" id="addline1" placeholder="Address Line1" value="{{ old( 'addline1') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="country_selector">Country</label>
                <div class="col-sm-8">
                  @include('admin.components.country')
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="exampleInputCp1">C.P.</label>
                <div class="col-sm-8">
                <input type="text" name="cp" class="form-control" id="exampleInputCp1" placeholder="C.P." value="{{ old( 'cp') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="currency">Currency</label>
                <div class="col-sm-8">
                  <!-- Currency -->
                  @include('admin.components.currency')
                </div>
            </div>
            
            <!-- /.card-body -->
            
            <div id="map"></div>
            <div class="card-footer">
                <a href="/shops" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
                <button type="submit" class="btn btn-primary float-right">Create</button>
            </div>
        </form>
        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d101408.2330017279!2d-122.15130702796371!3d37.41330279145996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb7495bec0189%3A0x7c17d44a466baf9b!2sMountain+View%2C+CA%2C+USA!5e0!3m2!1sen!2sin!4v1553663251022" height="600" frameborder="0" style="border:0" allowfullscreen=""></iframe> -->
        
    </div>
    <!-- /.card -->
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-md-6">

    </div>
    <!--/.col (right) -->
</div>
<!-- /.row -->
@endsection

@section('shopjs')
@include('admin.shop.js')
@endsection