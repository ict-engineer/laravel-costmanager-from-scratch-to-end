@extends('admin.roles.layout')
@section('rolecss')
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection
@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
    <!-- jquery validation -->
    <div class="card card-primary">
        <div class="card-header">
            <h1 class="card-title">Edit Role Info</h1>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" id="quickForm" action="{{ route('roles.update',$role->id) }}" method="POST" style="font-size:18px;padding:20px;">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputName1">Role Name</label>
                    <div>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="exampleInputName1" placeholder="Name" value="{{ old( 'name', $role->name) }}">
                      @if( $errors->has( 'name' ) )
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first( 'name' ) }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <!----Permissions on Users Module --->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Permissions on Users Module</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix row" style="margin-left:1em;">
                            <div class="icheck-success d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess5" name="List Users" {{ ( $role->hasPermissionTo("List Users")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess5" name="List Users" {{ ( old('List_Users') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess5">
                                List Users
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess6" name="New Users" {{ ( $role->hasPermissionTo("New Users")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess6" name="New Users" {{ ( old('New_Users') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess6">
                                New Users
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess7" name="Edit Users" {{ ( $role->hasPermissionTo("Edit Users")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess7" name="Edit Users" {{ ( old('Edit_Users') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess7">
                                Edit Users
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess8" name="Delete Users" {{ ( $role->hasPermissionTo("Delete Users")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess8" name="Delete Users" {{ ( old('Delete_Users') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess8">
                                Delete Users
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!----Permissions on Services Module --->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Permissions on Services Module</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix row" style="margin-left:1em;">
                            <div class="icheck-success d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess1" name="List Services" {{ ( $role->hasPermissionTo("List Services")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess1" name="List Services" {{ ( old('List_Services') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess1">
                                List Services
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess2" name="New Services" {{ ( $role->hasPermissionTo("New Services")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess2" name="New Services" {{ ( old('New_Services') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess2">
                                New Services
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess3" name="Edit Services" {{ ( $role->hasPermissionTo("Edit Services")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess3" name="Edit Services" {{ ( old('Edit_Services') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess3">
                                Edit Services
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess4" name="Delete Services" {{ ( $role->hasPermissionTo("Delete Services")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess4" name="Delete Services" {{ ( old('Delete_Services') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess4">
                                Delete Services
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!----Permissions on Providers Module --->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Permissions on Providers Module</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix row" style="margin-left:1em;">
                            <div class="icheck-success d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess9" name="List Providers" {{ ( $role->hasPermissionTo("List Providers")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess9" name="List Providers" {{ ( old('List_Providers') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess9">
                                List Providers
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess10" name="New Providers" {{ ( $role->hasPermissionTo("New Providers")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess10" name="New Providers" {{ ( old('New_Providers') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess10">
                                New Providers
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess11" name="Edit Providers" {{ ( $role->hasPermissionTo("Edit Providers")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess11" name="Edit Providers" {{ ( old('Edit_Providers') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess11">
                                Edit Providers
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess12" name="Delete Providers" {{ ( $role->hasPermissionTo("Delete Providers")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess12" name="Delete Providers" {{ ( old('Delete_Providers') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess12">
                                Delete Providers
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!----Permissions on Shops Module --->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Permissions on Shops Module</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix row" style="margin-left:1em;">
                            <div class="icheck-success d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess13" name="List Shops" {{ ( $role->hasPermissionTo("List Shops")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess13" name="List Shops" {{ ( old('List_Shops') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess13">
                                List Shops
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess14" name="New Shops" {{ ( $role->hasPermissionTo("New Shops")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess14" name="New Shops" {{ ( old('New_Shops') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess14">
                                New Shops
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess15" name="Edit Shops" {{ ( $role->hasPermissionTo("Edit Shops")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess15" name="Edit Shops" {{ ( old('Edit_Shops') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess15">
                                Edit Shops
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess16" name="Delete Shops" {{ ( $role->hasPermissionTo("Delete Shops")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess16" name="Delete Shops" {{ ( old('Delete_Shops') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess16">
                                Delete Shops
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!----Permissions on Materials Module --->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Permissions on Materials Module</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix row" style="margin-left:1em;">
                            <div class="icheck-success d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess17" name="List Materials" {{ ( $role->hasPermissionTo("List Materials")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess17" name="List Materials" {{ ( old('List_Materials') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess17">
                                List Materials
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess18" name="New Materials" {{ ( $role->hasPermissionTo("New Materials")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess18" name="New Materials" {{ ( old('New_Materials') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess18">
                                New Materials
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess19" name="Edit Materials" {{ ( $role->hasPermissionTo("Edit Materials")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess19" name="Edit Materials" {{ ( old('Edit_Materials') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess19">
                                Edit Materials
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess20" name="Delete Materials" {{ ( $role->hasPermissionTo("Delete Materials")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess20" name="Delete Materials" {{ ( old('Delete_Materials') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess20">
                                Delete Materials
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!----Permissions on Payments Module --->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Permissions on Payments Module</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix row" style="margin-left:1em;">
                            <div class="icheck-success d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess21" name="List Payments" {{ ( $role->hasPermissionTo("List Payments")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess21" name="List Payments" {{ ( old('List_Payments') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess21">
                                List Payments
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess22" name="New Payments" {{ ( $role->hasPermissionTo("New Payments")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess22" name="New Payments" {{ ( old('New_Payments') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess22">
                                New Payments
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess23" name="Edit Payments" {{ ( $role->hasPermissionTo("Edit Payments")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess23" name="Edit Payments" {{ ( old('Edit_Payments') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess23">
                                Edit Payments
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess24" name="Delete Payments" {{ ( $role->hasPermissionTo("Delete Payments")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess24" name="Delete Payments" {{ ( old('Delete_Payments') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess24">
                                Delete Payments
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!----Permissions on Front Users Module --->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Permissions on Contractors Module</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group clearfix row" style="margin-left:1em;">
                            <div class="icheck-success d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess25" name="List Clients" {{ ( $role->hasPermissionTo("List Clients")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess25" name="List Clients" {{ ( old('List_Clients') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess25">
                                List Clients
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess26" name="New Clients" {{ ( $role->hasPermissionTo("New Clients")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess26" name="New Clients" {{ ( old('New_Clients') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess26">
                                New Clients
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess27" name="Edit Clients" {{ ( $role->hasPermissionTo("Edit Clients")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess27" name="Edit Clients" {{ ( old('Edit_Clients') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess27">
                                Edit Clients
                                </label>
                            </div>
                            <div class="icheck-success  d-inline col-sm-3">
                            @if(old('name') == "")
                                <input type="checkbox" id="checkboxSuccess28" name="Delete Clients" {{ ( $role->hasPermissionTo("Delete Clients")) ? 'checked' : '' }}>
                            @else
                                <input type="checkbox" id="checkboxSuccess28" name="Delete Clients" {{ ( old('Delete_Clients') == "on") ? 'checked' : '' }}>
                            @endif
                                <label for="checkboxSuccess28">
                                Delete Clients
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            
            <div class="card-footer">
                <a href="/roles" class="btn btn-secondary float-right" style="margin-left:10px;">Cancel</a>
                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-md-2">

    </div>
    <!--/.col (right) -->
</div>
<!-- /.row -->
@endsection

@section('rolejs')
<!--- handle checkbox state change ---->
<script src="{{ asset('/js/roleCheck.js') }}"></script>
@endsection