@extends('admin.promocode.layout')
   
@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
    <!-- jquery validation -->
    <div class="card card-primary">
        <div class="card-header">
            <h1 class="card-title">Edit Promocode Info</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('promocode.update',$promocode->id) }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputName1">Name</label>
                    <div class="col-sm-8">
                      <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Name"  value="{{ old( 'name', $promocode->name) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="code">Code</label>
                    <div class="col-sm-8">
                      <input type="text" name="code" class="form-control" id="code" placeholder="Code"   value="{{ old( 'name', $promocode->code) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="discount">Discount</label>
                    <div class="col-sm-8">
                      <input type="text" name="discount" class="form-control" id="discount" placeholder="Discount"   value="{{ old( 'name', $promocode->discount) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="duration">Duration(months)</label>
                    <div class="col-sm-8">
                      <input type="text" name="duration" class="form-control" id="duration" placeholder="Duration"   value="{{ old( 'name', $promocode->duration) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="active">Active</label>
                    <div class="col-sm-8">
                        <input type="checkbox" name="active" data-bootstrap-switch id="active" {{ (old( 'active', $promocode->active) == "on") ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            
            <div class="card-footer">
                <a href="/promocode" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
                <button type="submit" class="btn btn-primary float-right">Save</button>
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

@section('promocodejs')
  @include('admin.promocode.js')
@endsection