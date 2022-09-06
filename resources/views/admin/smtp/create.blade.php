@extends('admin.smtp.layout')
   
@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
    <!-- jquery validation -->
    <div class="card card-primary">
        <div class="card-header">
            <h1 class="card-title">Create SMTP Info</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('smtp.store') }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="exampleInputName1">Name</label>
                    <div class="col-sm-8">
                      <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Name" value="{{ old( 'name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="server">SMTP Server</label>
                    <div class="col-sm-8">
                      <input type="text" name="server" class="form-control" id="server" placeholder="SMTP server" value="{{ old( 'server') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="port">Port</label>
                    <div class="col-sm-8">
                      <input type="text" name="port" class="form-control" id="port" placeholder="Port" value="{{ old( 'port') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Security</label>
                    <div class="col-sm-8">
                    <select name="security" class="form-control" value="{{ old('security') }}">
                      <option value="SSL" {{ ( old('security') == "SSL") ? 'selected' : '' }}>SSL</option>
                      <option value="TLS" {{ ( old('security') == "TLS") ? 'selected' : '' }}>TLS</option>
                      <option value="None" {{ ( old('security') == "None") ? 'selected' : '' }}>None</option>
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
                        value="{{ old( 'email') }}"
                    />
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
            </div>
            <!-- /.card-body -->
            
            <div class="card-footer">
                <a href="/smtp" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
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

@section('smtpjs')
  @include('admin.smtp.js')
@endsection