@extends('admin.roles.layout')
@section('content')
<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h2 class="text-white bg-info" style="text-align:center">Roles Info</h2>
            </div>
            <div class="card-body box-profile">
                <h3 class="profile-rolename text-center">{{ $role }}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                
                @if($permissions->count() == 0)
                    <br/>
                    <br/>
                    <p style="text-align:center;"><strong>No Permissions.</strong></p>
                @endif
                @foreach($permissions as $permission)
                  <li class="list-group-item">
                    <b>{{ $i++ }}</b> <a class="float-right">{{ $permission }}</a>
                  </li>
                @endforeach
                </ul>

                <div style="display: flex;justify-content: center;">
                    <a href="{{ route('roles.index') }}" class="btn btn-success">Back</a>
                <div>  
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection