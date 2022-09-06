@extends('admin.material.layout')
@section('materialcss')
<!--- file upload --->
<!-- <link rel="stylesheet" href="{{ asset('css/imageinput.css') }}"> -->

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
            <h1 class="card-title">Add Material</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('materials.store') }}" method="POST" style="font-size:18px;padding:20px;" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="providerlist">Provider</label>
                <div class="col-sm-8">
                  <select class="form-control select2" style="width: 100%;" name="providerlist" id="providerlist"></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="shoplist">Shop Name</label>
                <div class="col-sm-8">
                  <select class="form-control select2" style="width: 100%;" name="shoplist" id="shoplist"></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="exampleInputName1">Description</label>
                <div class="col-sm-8">
                <input type="text" name="description" class="form-control" id="exampleInputName1" placeholder="Material Description" value="{{ old( 'description') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="exampleInputAddline1">Brand</label>
                <div class="col-sm-8">
                <input type="text" name="brand" class="form-control" id="exampleInputAddline1" placeholder="Brand" value="{{ old( 'brand') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="inputsku1">SKU</label>
                <div class="col-sm-8">
                    <input type="text" name="sku"  placeholder="SKU" class="form-control" value="{{ old( 'sku') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="examplePartNo1">Part No.</label>
                <div class="col-sm-8">
                <input type="text" name="partno" class="form-control" id="examplePartNo1" placeholder="Part No." value="{{ old( 'partno') }}">
                </div>
            </div>                   
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="exampleInputCp1">Price</label>
                <div class="col-sm-8">
                <input type="text" name="price" class="form-control" id="exampleInputCp1" placeholder="Price" value="{{ old( 'price') }}">
                </div>
            </div>                   
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="exampleInputImage1">Image</label>
                <div class="col-sm-8">
                  <input type="text" name="imageurl" class="form-control" id="exampleInputImage1" placeholder="Image Url" value="{{ old( 'imageurl') }}">
                </div>
            </div>                   
            <div class="form-group row">
              <div class="col-sm-4">
                <div class="icheck-success d-inline">
                  <input type="checkbox" id="resetcheck" class="myCheckbox"/>  <label for="resetcheck">Upload Image</label>
                </div>
              </div>
              <div class="col-sm-8">
                <input id="image" type="file" id="image" name="image" value="{{ old( 'image') }}" disabled>
                <!-- <div class="image-input image-input-outline" id="kt_image_1" style="width:100%;">
                    <div class="image-input-wrapper" style="background-image: url(assets/media/users/100_1.jpg);width:100%;"></div>
                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                        <i class="fa fa-pen icon-sm text-muted"></i>
                        <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg">
                    </label>
                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary text-muted btn-shadow" data-action="cancel" data-toggle="tooltip" title="" data-original-title="Cancel avatar">
                        <strong>X</strong>
                    </span>
                </div>
                <span class="form-text text-muted" id="imagedes">Allowed file types: png, jpg, jpeg.</span> -->
              </div>
            </div>
            <!-- /.card-body -->
            
            <div class="card-footer">
                <a href="{{ route('materials.index') }}" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
                <button type="submit" class="btn btn-primary float-right">Create</button>
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

@section('materialjs')
  @include('admin.material.js')
@endsection