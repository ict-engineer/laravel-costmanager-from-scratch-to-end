@extends('admin.provider.layout')

@section('providercss')
<!-- select -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2/css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- flag -->
<link rel="stylesheet" href="{{ asset('bower_components/flag-icon-css/css/flag-icon.min.css') }}">
<!-- check box -->
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
            <h1 class="card-title">Edit Provider</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('providers.update',$provider->id) }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            @method('PUT')
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Personal Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputName1">Name</label>
                        <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Name" value="{{ old( 'name', $provider->name) }}">
                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputPhone1">Phone Number</label>
                        <div class="col-sm-8">
                          <div style="display:flex;">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                              </div>
                              @include('admin.components.phoneprefix')
                              <input type="text" name="phone" class="form-control  @error('phone') is-invalid @enderror" id="exampleInputPhone1" data-inputmask='"mask": "(999) 999-9999"'  value="{{ old( 'phonetmp', $provider->phone) }}" data-mask>
                              @if( $errors->has( 'phone' ) )
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first( 'phone' ) }}</strong>
                            </span>
                            @endif
                            </div>
                          </div>
                           
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
                            value="{{ old( 'email', $provider->email) }}"
                        />
                        @if( $errors->has( 'email' ) )
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first( 'email' ) }}</strong>
                            </span>
                        @endif
                        </div>
                        
                    </div>
                    <div>
                    <div class="icheck-success d-inline">
                        <input type="checkbox" id="resetcheck" name="resetpassword" style="vertical-align: middle;"><label for="resetcheck">   Reset Password</label>
                    </div>
                    </div>
                    <div style="margin-left:3rem;">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputPassword3">Password</label>
                        <div class="col-sm-8">
                        <input type="password" name="new_password" disabled class="form-control" id="exampleInputPassword3" placeholder="Password" value="{{ old( 'new_password') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputPassword2">Confirm Password</label>
                        <div class="col-sm-8">
                        <input type="password" name="confirm_password" disabled class="form-control  @error('confirm_password') is-invalid @enderror" id="exampleInputPassword2" placeholder="Confirm Password" value="{{ old( 'confirm_password') }}">
                        @if( $errors->has( 'confirm_password' ) )
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first( 'confirm_password' ) }}</strong>
                        </span>
                        @endif
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Company Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputCompany1">Company Name</label>
                        <div class="col-sm-8">
                        <input type="text" name="companyname" class="form-control @error('companyname') is-invalid @enderror" id="exampleInputCompany1" placeholder="Company" value="{{ old( 'companyname', $provider->companyname) }}">
                        @if( $errors->has( 'companyname' ) )
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first( 'companyname' ) }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="exampleInputAddline1">Address Line</label>
                        <div class="col-sm-8">
                        <input type="text" name="addline1" class="form-control" id="exampleInputAddline1" placeholder="Address Line1" value="{{ old( 'addline1', $provider->addline1) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                        <input type="text" name="addline2" class="form-control" id="exampleInputAddline2" placeholder="Address Line2" value="{{ old( 'addline2', $provider->addline2) }}">
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
                        <input type="text" name="cp" class="form-control" id="exampleInputCp1" placeholder="C.P." value="{{ old( 'cp', $provider->cp) }}">
                        </div>
                    </div>                   
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="/providers" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
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

@section('providerjs')
  @include('admin.provider.js')
@endsection