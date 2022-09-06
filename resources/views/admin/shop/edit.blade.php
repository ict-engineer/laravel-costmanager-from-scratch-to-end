@extends('admin.shop.layout')
   
@section('shopcss')
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!--- alert css --->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
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
            <h1 class="card-title">Edit shop</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('shops.update',$shop->id) }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            @method('PUT')
            <input type="hidden" name="lat" id="lat" value="{{ old( 'lat', $shop->lat) }}">
            <input type="hidden" name="lng" id="lng" value="{{ old( 'lng', $shop->lng) }}">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="providerlist">Provider</label>
                <div class="col-sm-8">
                  <select class="form-control select2" style="width: 100%;height: calc(2.25rem + 2px);" name="providerlist" id="providerlist"></select>
                </div>
            </div>
            <input type="hidden" name="provider_id" id="provider_id" value="{{ $shop->provider_id }}">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="exampleInputName1">Name</label>
                <div class="col-sm-8">
                <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Name" value="{{ old( 'name', $shop->name) }}">
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="exampleInputAddline1">Address Line1</label>
                <div class="col-sm-8">
                <input type="text" id="addline1" name="addline1" class="form-control" id="exampleInputAddline1" placeholder="Address Line1" value="{{ old( 'addline1', $shop->addline1) }}">
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
                <input type="text" id="cp" name="cp" class="form-control" id="exampleInputCp1" placeholder="C.P." value="{{ old( 'cp', $shop->cp) }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="currency">Currency</label>
                <div class="col-sm-8">
                  <!-- Currency -->
                  @include('admin.components.currency')
                </div>
            </div>    
            <div id="map"></div>               
            <!-- /.card-body -->
            <div class="card-footer">
                <a class="btn btn-danger text-white ml-10 remove-shop" data-id="{{ $shop->id }}" data-action="{{ route('shops.destroy',$shop->id) }}">Delete Shop</a>
                <a href="/shops" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
                <button type="submit" class="btn btn-primary float-right">Update</button>
            </div>
        </form>
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