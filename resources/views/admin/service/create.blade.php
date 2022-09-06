@extends('admin.service.layout')
   
@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
    <!-- jquery validation -->
    <div class="card card-primary">
        <div class="card-header">
            <h1 class="card-title">Create service Info</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('services.store') }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputName1">Name</label>
                    <div class="col-sm-8">
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="exampleInputName1" placeholder="Name" value="{{ old( 'name') }}">
                      @if( $errors->has( 'name' ) )
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first( 'name' ) }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Spanish</label>
                    <div class="col-sm-8">
                      <input type="text" name="spanish" class="form-control" placeholder="Spanish Name" value="{{ old( 'spanish') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">French</label>
                    <div class="col-sm-8">
                      <input type="text" name="french" class="form-control" placeholder="French Name" value="{{ old( 'french') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Italian</label>
                    <div class="col-sm-8">
                      <input type="text" name="italian" class="form-control" placeholder="Italian Name" value="{{ old( 'italian') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Russian</label>
                    <div class="col-sm-8">
                      <input type="text" name="russian" class="form-control" placeholder="Russian Name" value="{{ old( 'russian') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">German</label>
                    <div class="col-sm-8">
                      <input type="text" name="german" class="form-control" placeholder="German Name" value="{{ old( 'german') }}">
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            
            <div class="card-footer">
                <a href="/services" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
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

@section('servicejs')
<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script>
$(document).ready(function () {
  $('#quickForm').validate({
    rules: {
      spanish: {
        required: true,
      },
      german: {
        required: true,
      },
      italian: {
        required: true,
      },
      russian: {
        required: true,
      },
      name: {
        required: true,
      },
      french: {
        required: true,
      },
    },
    messages: {
      spanish: {
        required: "Please input a service name in Spanish.",
      },
      german: {
        required: "Please input a service name in German.",
      },
      french: {
        required: "Please input a service name in French.",
      },
      russian: {
        required: "Please input a service name in Russian.",
      },
      name: {
        required: "Please input a service name in English.",
      },
      italian: {
        required: "Please input a service name in Italian",
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.col-sm-8').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
@endsection