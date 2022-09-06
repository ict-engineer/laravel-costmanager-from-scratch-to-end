@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/data-tables.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('custom_components/dropify/css/dropify.min.css') }}">
<style>
    #ajaxModel {
        max-width: 400px;
        overflow: hidden;
        overflow-y:auto;
    }
    .newimage-btn {
        position: absolute;
        right: 6px;
        top: 6px;
    }
    .image-div {
        width: 150px;
        height: 150px;
        min-height: 50px !important;
        position: relative;
    }
    .modal {
        max-height: 90%;
    }
    @media (min-width: 600px)
    {
            .btn i {
            float: left;
            margin-right: 8px;
        }
    }
    #uploadModel {
        max-width: 500px;
    }

    #progressModal {
        top:40% !important;
        line-height: 50px;
        text-align:center;
        width:250px; 
        height: 50px;
        background-color:rgb(255, 122, 112);
        color:white;
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
    }
</style>
@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.My Materials') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.My Materials') }}
    </li>
</ol>
@endsection
@section('content')
<div class="section section-data-tables">
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col m3 s12 display-flex justify-content-start">
                            <h4 class="card-title" style="display:flex;align-items:center;"><i class="material-icons">thumb_up</i>{{ __('messages.My Materials') }}</h4>
                        </div>
                        <div class="col m9 s12 display-flex justify-content-end align-items-center">
                            <a class="btn waves-effect waves-light border-round z-depth-4 mr-1" href="javascript:void(0)" id="uploadMaterials">
                                <i class="material-icons">file_upload</i>
                                <span class="hide-on-small-only">{{ __('messages.Upload') }} {{ __('messages.Materials') }}</span>
                            </a>
                            <a class="btn waves-effect waves-light border-round z-depth-4 mr-1" href="/user/getCMaterials" id="downloadList">
                                <i class="material-icons">file_download</i>
                                <span class="hide-on-small-only">{{ __('messages.Download') }} {{ __('messages.List') }}</span>
                            </a>
                            <a class="add-file-btn btn waves-effect waves-light border-round z-depth-4" href="javascript:void(0)" id="newcmaterials">
                                <i class="material-icons">add</i>
                                <span class="hide-on-small-only">{{ __('messages.New') }} {{ __('messages.Material') }}</span>
                            </a>
                        </div>
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
                                        <!-- <th>Expense Type</th> -->
                                        <th>{{ __('messages.Provider') }}</th>
                                        <th>{{ __('messages.Description') }}</th>
                                        <th>{{ __('messages.Brand') }}</th>
                                        <th>SKU</th>
                                        <th>{{ __('messages.Part No') }}</th>
                                        <th>{{ __('messages.Price') }}</th>
                                        <th>{{ __('messages.Image') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalheader">{{ __('messages.New') }} {{ __('messages.Material') }}</h6>
            </div>
            
            <div class="divider mt-5 mb-5"></div>
            <div class="modal-body">
                <form id="sendForm" name="sendForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="typeid" id="typeid">
                    <div class="input-field">
                        <i class="material-icons prefix">room_service</i>
                        <label for="name">{{ __('messages.Provider') }}</label>
                        <input class="validate mainInfoInput" type="text" name="provider" id="provider" >
                        <div class="error" id="errorprovider">
                        </div>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">info_outline</i>
                        <label for="description">{{ __('messages.Description') }}</label>
                        <input class="validate mainInfoInput" type="text" name="description" id="description" >
                        <div class="error" id="errordescription">
                        </div>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">branding_watermark</i>
                        <label for="newbrand">{{ __('messages.Brand') }}</label>
                        <input type="text" class="validate mainInfoInput" name="brand" id="newbrand" >
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">shop</i>
                        <label for="newsku">SKU</label>
                        <input type="text" class="validate mainInfoInput" name="sku" id="newsku">
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">confirmation_number</i>
                        <label for="newpartno">{{ __('messages.Part No') }}.</label>
                        <input type="text" class="validate mainInfoInput" name="partno" id="newpartno">
                    </div>                   
                    <div class="input-field">
                        <i class="material-icons prefix">attach_money</i>
                        <label for="price">{{ __('messages.Price') }}</label>
                        <input class="validate mainInfoInput" type="text" name="price" id="price" >
                        <div class="error" id="errorprice">
                        </div>
                    </div>
                    <div class="input-field">
                        <div class="display-flex justify-content-center">
                            <div class="image-div" style="width:auto;height:auto;">
                                <img src="{{ asset('imgs/upload_image.png') }}" width="150" height="150"  id="sourceLogoImg"></img>

                            <!-- <div class="logopreview"></div> -->
                                <button class="btn-floating waves-effect waves-light newimage-btn" id="select-logo-files"><i class="material-icons">add_a_photo</i></button>
                                <div class="upfilewrapper" style="display:none;" id="logoImageDiv">
                                    <input id="Upload" type="file" name="image"  accept=".png,.jpeg,.jpg" data-default-file="" data-allowed-file-extensions='["png", "jpg", "jpeg"]'/>
                                </div>
                            </div>
                        </div>
                        <div class="error" id="errorimage">
                        </div>
                    </div>
                    <div  class="mt-10 mb-3 user-edit-btns display-flex  justify-content-end ">
                        <button type="submit" class="btn-small indigo" id="saveBtn" value="create">{{ __('messages.Add') }}</button>
                        <button class="btn-small btn-light-pink" id="cancelBtn" style="margin-left:10px;" value="cancel">{{ __('messages.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadModel" aria-hidden="true">
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
                        <button class="btn-small btn-light-pink" id="cancelUploadBtn" style="margin-left:10px;" value="cancel">{{ __('messages.Cancel') }}</button>
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
@include('user.client.cmaterial.js')
@endsection