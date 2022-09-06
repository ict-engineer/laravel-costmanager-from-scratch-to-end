@extends('admin.service.layout')
@section('content')
<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h2 class="text-white bg-info" style="text-align:center">Service Info</h2>
            </div>
            <div class="card-body box-profile">
                <h3 class="profile-servicename text-center">{{ $service->name }}</h3>

                <div style="display: flex;justify-content: center;">
                    <a href="{{ route('services.index') }}" class="btn btn-success">Back</a>
                <div>  
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection