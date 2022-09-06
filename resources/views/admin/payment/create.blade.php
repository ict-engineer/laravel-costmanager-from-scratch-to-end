@extends('admin.payment.layout')
   
@section('paymentcss')
<!-- select -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- flag -->
<link rel="stylesheet" href="{{ asset('bower_components/flag-icon-css/css/flag-icon.min.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/summernote/summernote-bs4.css') }}">

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
            <h1 class="card-title">Create Payment</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        
        <form role="form" id="quickForm" action="{{ route('payments.store') }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="country_selector">Country</label>
                <div class="col-sm-8">
                    @include('admin.components.country')
                </div>
            </div>
              
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="name">Name</label>
                <div class="col-sm-8">
                <input type="text" name="name" id="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Name" value="{{ old( 'name') }}">
                @if( $errors->has( 'name' ) )
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first( 'name' ) }}</strong>
                </span>
                @endif
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="exampleInputCp1">Number of Users</label>
                <div class="col-sm-8">
                <input type="text" name="numberofusers" class="form-control" id="exampleInputCp1" placeholder="Number of Users" value="{{ old( 'numberofusers') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="currency">Currency</label>
                <div class="col-sm-8">
                  <!-- Currency -->
                    @include('admin.components.currency')
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="price">Price</label>
                <div class="col-sm-8">
                <input type="text" name="price" class="form-control" id="price" placeholder="Price" value="{{ old( 'price') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="description">Description</label>
                <div class="col-sm-8"></div>
                <div class="col-sm-12">
                  <textarea class="textarea form-control  @error('description') is-invalid @enderror" id="description" name="description" placeholder="Place input description."
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                 @if( $errors->has( 'description' ) )
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first( 'description' ) }}</strong>
                </span>
                @endif
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="/payments" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
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

@section('paymentjs')
@include('admin.payment.js')
@endsection