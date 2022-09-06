@extends('admin.user.layout')
@section('content')
<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h2 class="text-white bg-info" style="text-align:center">User Info</h2>
            </div>
            <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('imgs/avatar1.png') }}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->name }}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>E-Mail</b> <a class="float-right">{{ $user->email }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Phone Number</b> <a class="float-right">{{ $user->phone }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Role</b> <a class="float-right">{{ $user->usertype }}</a>
                  </li>
                </ul>

                <div style="display: flex;justify-content: center;">
                    <a href="{{ route('usersetup.index') }}" class="btn btn-success">Back</a>
                <div>  
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection