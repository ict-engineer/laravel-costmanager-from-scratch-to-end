@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/data-tables.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<!-- file upload -->
<link rel="stylesheet" type="text/css" href="{{ asset('custom_components/dropify/css/dropify.min.css') }}">
<style>
    #ajaxModel {
        max-width: 500px;
        overflow-y:auto;
    }
    #progressModal {
        top:40% !important;
        line-height: 50px;
        text-align:center;
        width:250px; 
        height: 50px;
        background-color:rgb(255, 122, 112);
        color:white;
        overflow-y:auto;
    }
    #uploadingModal {
        top:40% !important;
        text-align:center;
        padding: 15px 10px;
        border-radius: 5px;
        width:280px; 
        height: 150px;
        background-color:rgb(255, 122, 112);
        overflow: hidden;
        color:white;
        overflow-y:auto;
    }
</style>
@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.Provider') }} {{ __('messages.Shops') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.Provider') }} {{ __('messages.Shops') }}
    </li>
</ol>
@endsection
@section('content')
<div class="section section-data-tables">
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="display-flex justify-content-between">
                        <h4 class="card-title" style="display:flex;align-items:center;"><i class="material-icons">shopping_cart</i>{{ __('messages.Shops') }}</h4>
                        <a class="add-file-btn btn waves-effect waves-light border-round z-depth-4" href="{{ route('user.providershops.create') }}" style="display:flex;align-items:center;">
                            <i class="material-icons">add</i>
                            <span class="hide-on-small-only">{{ __('messages.New') }} {{ __('messages.Shop') }}</span>
                        </a>
                    </div>
                    <div class="divider mb-1 mt-1"></div>
                    <div class="row">
                        <div class="col s12">
                            <table id="page-length-option" class="display">
                                <thead>
                                    <tr>
                                        @if($i != -1)
                                        <th>No</th>
                                        @endif
                                        <th>{{ __('messages.Name') }}</th>
                                        <th>{{ __('messages.Address') }}</th>
                                        <th>{{ __('messages.Country') }}</th>
                                        <th>{{ __('messages.Currency') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shops as $shop)
                                    <tr>
                                        @if($i != -1)
                                            <td>{{ ++$i }}</td>
                                        @endif
                                        <td>{{ $shop->name }}</td>
                                        <td>{{ $shop->addline1 }}</td>
                                        <td>{{ $shop->country }}</td>
                                        <td>{{ $shop->currency }}</td>
                                        <td>
                                            <a href="{{ route('user.providershops.edit',$shop->id) }}" class="tooltipped" data-position="bottom" data-tooltip="{{ __('messages.Edit') }}"><i class="material-icons">edit</i></a>
                                            <a href="javascript:void(0)" class="remove-shop tooltipped" data-id="{{ $shop->id }}" data-action="{{ route('user.providershops.destroy',$shop->id) }}" data-position="bottom" data-tooltip="{{ __('messages.Delete') }}"><i class="material-icons">delete</i></a>
                                            <a id="uploadMaterials" data-id="{{ $shop->id }}" href="javascript:void(0)" class="tooltipped" data-position="bottom" data-tooltip="{{ __('messages.Upload') }}"><i class="material-icons">file_upload</i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true" style="max-width:200px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6 class="modal-title">{{ __('messages.Upload a list of materials using a CSV file') }}</h6>
               
            </div>
            
            <div class="modal-body">
                <form id="shopForm" name="shopForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="shop_id" id="shop_id">
                    <div class="row">
                        <div class="col s12">
                            <input type="file" accept=".csv" id="input-file-now" class="dropify" data-default-file="" data-allowed-file-extensions='["csv"]' name="file" />
                        </div>
                    </div>
                    <div class=" card gradient-45deg-red-pink">
                        <div class="card-alert white-text" id="errorfile">
                        </div>
                    </div>
                    <label>
                        <input class="with-gap" id="customRadio1" name="customRadio" value="addM" type="radio" checked /><span>{{ __('messages.Add the files to the existing list') }}</span>
                    </label>
                    <label>
                        <input class="with-gap" id="customRadio2" name="customRadio" value="resetM" type="radio" /><span>{{ __('messages.Delete old list and replace with new one') }}</span>
                    </label>
                    <div  class="mt-3 mb-3 user-edit-btns display-flex  justify-content-end ">
                        <button type="submit" class="btn-small indigo" id="uploadBtn" value="create">{{ __('messages.Upload') }}</button>
                        <button class="btn-small btn-light-pink" id="cancelBtn" style="margin-left:10px;" value="cancel">{{ __('messages.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="progressModal" class="modal fade" role="dialog">
        {{ __('messages.Processing...') }}
    </div>
    <div id="uploadingModal" class="modal fade" role="dialog">
      <p id="uploadingCount" style="margin-bottom: 5px !important;">0 materials uploaded of</p>
      <p id="uploadingTotal" style="margin-top: 0px !important;">10000 materials...</p>
      <button type="submit" class="btn btn-light-purple waves-effect waves-light" style="border-radius: 5px;" id="cancelUploading" >{{ __('messages.Cancel') }}</button>
    </div>
</div>
@endsection
@section('contentjs')
@include('user.provider.shop.jsindex')
@endsection