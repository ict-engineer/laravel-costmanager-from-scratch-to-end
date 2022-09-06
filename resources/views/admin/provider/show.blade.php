@extends('admin.provider.layout')
@section('content')
<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h2 class="text-white bg-info" style="text-align:center">Provider Info</h2>
            </div>
            <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-provider-img img-fluid img-circle"
                       src="{{ asset('imgs/avatar1.png') }}"
                       alt="provider profile picture">
                </div>

                <h3 class="profile-providername text-center">{{ $provider->name }}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>E-Mail</b> <a class="float-right">{{ $provider->email }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Phone Number</b> <a class="float-right">{{ $provider->phone }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Company</b> <a class="float-right">{{ $provider->companyname }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Address Line</b> <a class="float-right">{{ $provider->addline1 }}</a>
                  </li>
                  <li class="list-group-item">
                    <b></b> <a class="float-right">{{ $provider->addline2 }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Country</b> <a class="float-right">{{ $provider->country }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>C.P.</b> <a class="float-right">{{ $provider->cp }}</a>
                  </li>
                </ul>

                <div style="display: flex;justify-content: center;">
                    <a href="{{ route('providers.index') }}" class="btn btn-success">Back</a>
                <div>  
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection