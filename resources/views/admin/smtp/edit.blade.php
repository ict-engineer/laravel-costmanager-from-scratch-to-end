@extends('admin.smtp.layout')

@section('smtpcss')
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
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
            <h1 class="card-title">Edit SMTP Info</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('smtp.update',$smtp->id) }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            @method('PUT')
            <div class="card-body">
            <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputName1">Name</label>
                    <div class="col-sm-8">
                      <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Name" value="{{ old( 'name', $smtp->name) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="server">SMTP Server</label>
                    <div class="col-sm-8">
                      <input type="text" name="server" class="form-control" id="server" placeholder="SMTP server" value="{{ old( 'server', $smtp->server) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="port">Port</label>
                    <div class="col-sm-8">
                      <input type="text" name="port" class="form-control" id="port" placeholder="Port" value="{{ old( 'port', $smtp->port) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Security</label>
                    <div class="col-sm-8">
                    <select name="security" class="form-control" value="{{ old('security') }}">
                        @if(old('security') == "")
                        <option value="SSL" {{ ( $smtp->security == "SSL") ? 'selected' : '' }}>SSL</option>
                        <option value="TLS" {{ ( $smtp->security == "TLS") ? 'selected' : '' }}>TLS</option>
                        <option value="None" {{ ( $smtp->security == "None") ? 'selected' : '' }}>None</option>
                        @else
                          <option value="SSL" {{ ( old('security') == "SSL") ? 'selected' : '' }}>SSL</option>
                          <option value="TLS" {{ ( old('security') == "TLS") ? 'selected' : '' }}>TLS</option>
                          <option value="None" {{ ( old('security') == "None") ? 'selected' : '' }}>None</option>
                        @endif
                      
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputEmail1">Email address</label>
                    <div class="col-sm-8">
                      <input
                        type="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        name="email"
                        placeholder="Email Address"
                        required
                        value="{{ old( 'email', $smtp->email) }}"
                    />
                    </div>
                </div>
                <div class="icheck-success d-inline">
                  <input type="checkbox" name="resetpassword" id="resetcheck" class="myCheckbox"/>  <label for="resetcheck">Reset Password</label>
                </div>
                <div style="margin-left:3rem;">
                <div class="form-group row">
                    </br>
                    <label class="col-sm-4 col-form-label" for="exampleInputPassword1">New Password</label>
                    <div class="col-sm-8">
                      <input type="password" name="new_password" disabled class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputPassword2">Confirm Password</label>
                    <div class="col-sm-8">
                      <input type="password" name="confirm_password" class="form-control  @error('confirm_password') is-invalid @enderror" id="exampleInputPassword2" disabled placeholder="Confirm Password">
                      @if( $errors->has( 'confirm_password' ) )
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first( 'confirm_password' ) }}</strong>
                      </span>
                    @endif
                    </div>
                    
                </div>
                </div>
            </div>
            <!-- /.card-body -->
            
            <div class="card-footer">
                <a href="/smtp" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
                <button type="submit" class="btn btn-primary float-right">Submit</button>
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

@section('smtpjs')
@include('admin.smtp.js')
<script>
$(document).on('click', '.myCheckbox', function () {
  
  if ($(this).is(':checked'))  
  {
      document.getElementById("exampleInputPassword1").disabled = false;
      document.getElementById("exampleInputPassword2").disabled = false;
  }
  else
  {
      document.getElementById("exampleInputPassword1").disabled = true;
      document.getElementById("exampleInputPassword2").disabled = true;
  }
});
</script>

@endsection