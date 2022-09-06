@extends('admin.user.layout')
   
@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
    <!-- jquery validation -->
    <div class="card card-primary">
        <div class="card-header">
            <h1 class="card-title">Create User Info</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('usersetup.store') }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputName1">Name</label>
                    <div class="col-sm-8">
                      <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Name" value="{{ old( 'name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputPhone1">Phone Number</label>
                    <div class="col-sm-8">
                      <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="exampleInputPhone1" placeholder="Phone Number" value="{{ old( 'phone') }}">
                        @if( $errors->has( 'phone' ) )
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first( 'phone' ) }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputEmail1">Email address</label>
                    <div class="col-sm-8">
                      <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="exampleInputEmail1"
                        name="email"
                        placeholder="Email Address"
                        required
                        value="{{ old( 'email') }}"
                    />
                    @if( $errors->has( 'email' ) )
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first( 'email' ) }}</strong>
                        </span>
                    @endif
                    </div>
                    
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputPassword3">Password</label>
                    <div class="col-sm-8">
                      <input type="password" name="new_password" class="form-control" id="exampleInputPassword3" placeholder="Password" value="{{ old( 'new_password') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputPassword2">Confirm Password</label>
                    <div class="col-sm-8">
                      <input type="password" name="confirm_password" class="form-control  @error('confirm_password') is-invalid @enderror" id="exampleInputPassword2" placeholder="Confirm Password" value="{{ old( 'confirm_password') }}">
                      @if( $errors->has( 'confirm_password' ) )
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first( 'confirm_password' ) }}</strong>
                      </span>
                      @endif
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Give Role</label>
                    <div class="col-sm-8">
                    <select name="usertype" class="form-control" value="{{ old('usertype') }}">
                      @foreach($roles as $role)
                          <option value="{{$role}}" {{ ( old('usertype') == "$role") ? 'selected' : '' }}>{{$role}}</option>
                      @endforeach
                    </select>
                    </div>
                </div>
                
            </div>
            <!-- /.card-body -->
            
            <div class="card-footer">
                <a href="/usersetup" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
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

@section('userjs')
<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script>
$(document).ready(function () {
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      new_password: {
        required: true,
        minlength: 8
      },
      confirm_password: {
        required: true,
        minlength: 8
      },
      name: {
        required: true,
      },
      phone: {
        required: true,
        minlength: 10,
        maxlength: 15
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      new_password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 8 characters long"
      },
      confirm_password: {
        required: "Please provide a confirm_password",
        minlength: "Your password must be at least 8 characters long"
      },
      name: {
        required: "Please enter a name",
      },
      phone: {
        required: "Please provide a phone number",
        minlength: "Your phone number must be at least 10 characters long",
        maxlength: "Your phone number must be less than 15 characters long"
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