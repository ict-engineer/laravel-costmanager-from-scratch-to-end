@extends('admin.shop.layout')

@section('shopcss')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- file upload -->
<link rel="stylesheet" type="text/css" href="{{ asset('custom_components/dropify/css/dropify.min.css') }}">

<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
<div class="row" style="margin:10px;font-size:18px;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 style="display:inline;margin-left:0.5rem;"><i class="fas fa-shopping-cart nav-icon"></i></h3>
                @can('New Shops')
                    <a style="display:inline;float:right;margin-right:0.5rem;" class="btn btn-primary" href="{{ route('shops.create') }}"><i class="fas fa-shopping-cart"></i> {{ __('messages.New') }} Shop</a>
                @endcan
            </div>
                <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover" style="font-size:18px;vertical-align: middle;">
                    <thead>
                    <tr role="row" class="text-uppercase">
                        @if($i != -1)
                        <th>No</th>
                        @endif
                        <th>Provider</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Country</th>
                        <th>Currency</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($shops as $shop)
                        <tr>
                        @if($i != -1)
                            <td>{{ ++$i }}</td>
                        @endif
                        <td>{{ $shop->provider->companyname }}</td>
                        <td>{{ $shop->name }}</td>
                        <td>{{ $shop->addline1 }}</td>
                        <td>{{ $shop->country }}</td>
                        <td>{{ $shop->currency }}</td>
                        <td>
                            @can('Edit Shops')
                                <a class="btn btn-info " href="{{ route('shops.edit',$shop->id) }}">Edit</a>
                            @endcan
                            @can('Delete Shops')
                                <button class="btn btn-danger  remove-shop" data-id="{{ $shop->id }}" data-action="{{ route('shops.destroy',$shop->id) }}">Delete</button>
                                <a class="btn btn-success" id="uploadMaterials" data-id="{{ $shop->id }}" href="javascript:void(0)" data-toggle="tooltip">Upload Materials</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title">Upload a list of materials using a CSV file</h4>
            </div>
            <div class="modal-body">
                <form id="shopForm" name="shopForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="shop_id" id="shop_id">
                    <div class="form-group">
                        <div class="row section">
                            <div class="col s12">
                                <input type="file" accept=".xls,.xlsx,.csv,.txt" id="input-file-now" class="dropify" data-default-file="" data-allowed-file-extensions='["csv", "txt", "xls", "xlsx"]' name="file" />
                            </div>

                        </div>
                        <div class=" card gradient-45deg-red-pink">
                            <div class="card-alert white-text" id="errorfile">
                            </div>
                        </div>
                    </div>

                    <div class="form-group font-18">
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" value="addM" checked>
                            <label for="customRadio1" class="custom-control-label">Add the files to the existing list</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" value="resetM">
                            <label for="customRadio2" class="custom-control-label">Delete old list and replace with new one</label>
                        </div>
                    </div>

                    <div style="display:flex;float:right;">
                     <button type="submit" class="btn btn-primary" id="uploadBtn" value="create">Upload</button>
                     <button class="btn btn-secondary" id="cancelBtn" style="margin-left:10px;margin-right:3em;" value="cancel">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    
</div>
@endsection
@section('shopjs')
@include('admin.shop.jsindex')
@endsection