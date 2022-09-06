@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/data-tables.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<!-- file upload -->
<link rel="stylesheet" type="text/css" href="{{ asset('custom_components/dropify/css/dropify.min.css') }}">

<!-- select2 -->
<link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2-materialize.css') }}" type="text/css">

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-todo.css') }}">
<style>
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
    @media (min-width: 600px)
    {
            .btn i {
            float: left;
            margin-right: 8px;
        }
    }
</style>
@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.Provider') }} {{ __('messages.Materials') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.Provider') }} {{ __('messages.Materials') }}
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
                        <div class="col m6 s12 display-flex justify-content-start">
                            <h4 class="card-title" style="display:flex;align-items:center;"><i class="material-icons">thumb_up</i>{{ __('messages.Materials') }}</h4>
                        </div>
                        <div class="col m6 s12 display-flex justify-content-end align-items-center">
                            <span style="padding-right: 5px;">{{$materials->total()}} {{ __('messages.Materials') }}</span>
                            <a id="newMaterial" class="add-file-btn btn waves-effect waves-light border-round z-depth-4" href="javascript:void(0)">
                                <i class="material-icons">add</i>
                                <span class="hide-on-small-only">{{ __('messages.New') }} {{ __('messages.Material') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="divider mb-1 mt-1"></div>
                    <form class="form mb-1 " method="GET">
                        <div class="row">
                            <div class="col m4 s12">
                                <div class="display-flex" style="align-items:center;">
                                    <select class="select2 browser-default mb-0" name="shoplist" id="shoplist"></select> 
                                    <span style="padding-left: 5px;">{{ __('messages.Shop') }} {{ __('messages.Materials') }}</span>
                                </div>
                            </div>
                            <div class="col m8 s12 display-flex justify-content-end">
                                <button type="submit" class="btn indigo waves-effect waves-light display-flex mt-1" style="align-items:center;"><i class="material-icons">search</i> {{ __('messages.Search') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col s12">
                            <table id="data-table-simple" class="display">
                                <thead>
                                    <tr>
                                        @if($i != -1)
                                        <th>No</th>
                                        @endif
                                        <th>{{ __('messages.Shop Name') }}</th>
                                        <th>{{ __('messages.Description') }}</th>
                                        <th>{{ __('messages.Brand') }}</th>
                                        <th>Sku</th>
                                        <th>{{ __('messages.Part No') }}.</th>
                                        <th>{{ __('messages.Price') }}</th>
                                        <th>{{ __('messages.Image') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($materials as $material)
                                    <tr  id="row_{{$material->id}}">
                                    @if($i != -1)
                                        <td>{{ ++$i }}</td>
                                    @endif
                                    <td>{{ $material->shoplist }}</td>
                                    <td>{{ $material->description }}</td>
                                    <td>{{ $material->brand }}</td>
                                    <td>{{ $material->sku }}</td>
                                    <td>{{ $material->partno }}</td>
                                    <td>{{ $material->price }} {{ $material->currency }}</td>
                                    <td>
                                        <img src="{{ $material->image }}"  alt="Image" width="150" height="150">
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="editMaterial tooltipped" data-id="{{ $material->id }}" data-action="{{ route('user.providermaterials.edit',$material->id) }}" data-position="bottom" data-tooltip="{{ __('messages.Edit') }}"><i class="material-icons">edit</i></a>
                                        <a href="javascript:void(0)" class="remove-material tooltipped" data-id="{{ $material->id }}" data-action="{{ route('user.providermaterials.destroy',$material->id) }}" data-position="bottom" data-tooltip="{{ __('messages.Delete') }}"><i class="material-icons">delete</i></a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $materials->appends($filter)->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="todo-compose-sidebar" id="newModal">
    <div class="card quill-wrapper">
        <div class="card-content pt-0">
            <div class="card-header display-flex pb-2">
                <h3 class="card-title" id="modalTitle">{{ __('messages.New') }} {{ __('messages.Material') }}</h3>
                <div class="close close-icon">
                    <i class="material-icons">close</i>
                </div>
            </div>
            <div class="divider"></div>
            <!-- form start -->
            <form role="form" id="newForm" action="{{ route('user.providermaterials.store') }}" method="POST" class="mt-1" enctype="multipart/form-data">
                @csrf
                
                <div class="input-field mt-10">
                    <i class="material-icons prefix">shopping_cart</i>
                    <div style="display:flex;margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">
                        <select class="select2 browser-default" style="width: 100%;" name="shoplist" id="newshoplist"></select>
                        <label for="shoplist">{{ __('messages.Shop Name') }}</label>
                    </div>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">description</i>
                    <label for="newdescription">{{ __('messages.Description') }}</label>
                    <input type="text" name="description" id="newdescription" >
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">branding_watermark</i>
                    <label for="newbrand">{{ __('messages.Brand') }}</label>
                    <input type="text" name="brand" id="newbrand" >
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">shop</i>
                    <label for="newsku">SKU</label>
                        <input type="text" name="sku" id="newsku">
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">confirmation_number</i>
                    <label for="newpartno">{{ __('messages.Part No') }}.</label>
                    <input type="text" name="partno" id="newpartno">
                </div>                   
                <div class="input-field">
                    <i class="material-icons prefix">attach_money</i>
                    <label for="newprice">{{ __('messages.Price') }}</label>
                    <input type="text" name="price" id="newprice">
                </div>                   
                <label class="text-black">
                    <input type="checkbox" id="newresetcheck">
                    <span>{{ __('messages.Upload') }} {{ __('messages.Image') }}</span>
                </label>
                <div class="input-field" id="newUrlImgDiv">
                    <i class="material-icons prefix">image</i>
                    <label for="newUploadUrl">{{ __('messages.Image') }}</label>
                    <input type="text" name="imageurl" id="newUploadUrl">
                    <div class="display-flex justify-content-center">
                        <img width="150" id="newUrlImage"></img>
                    </div>
                </div>                   
                
                <div class="input-field" id="newUploadImageDiv" style="display:none;">
                    <div class="display-flex justify-content-center">
                        <div class="image-div" style="width:auto;height:auto;">
                            <img src="{{ asset('imgs/upload_image.png') }}" width="150"  id="newSourceImg"></img>

                        <!-- <div class="logopreview"></div> -->
                            <button class="btn-floating waves-effect waves-light newimage-btn" id="select-new-logo-files"><i class="material-icons">add_a_photo</i></button>
                            <div class="upfilewrapper" style="display:none;" id="newLogoImageDiv">
                                <input id="newUpload" type="file" name="image"  accept=".png,.jpeg,.jpg" data-default-file="" data-allowed-file-extensions='["png", "jpg", "jpeg"]'/>
                            </div>
                        </div>
                    </div>
                    <div class="error" id="errorimage">
                    </div>
                </div>
                <div class="card-action pl-0 pr-0 right-align">
                    <button class="btn-small waves-effect waves-light add-todo" type="submit" id="saveBtn">
                        <span>{{ __('messages.Add') }}</span>
                    </button>
                </div>
            </form>
            
            <!-- form start end-->
        </div>
    </div>
</div>

<!-- edit -->
<div class="todo-compose-sidebar" id="editModal">
    <div class="card quill-wrapper">
        <div class="card-content pt-0">
            <div class="card-header display-flex pb-2">
                <h3 class="card-title" id="modalTitle">{{ __('messages.Edit') }} {{ __('messages.Material') }}</h3>
                <div class="close close-icon">
                    <i class="material-icons">close</i>
                </div>
            </div>
            <div class="divider"></div>
            <!-- form start -->
            <form role="form" id="editForm" action="{{ route('user.providermaterials.update',0) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                <input type="hidden" name="editmaterialId" id="editmaterialId">
                <div class="input-field mt-10">
                    <i class="material-icons prefix">shopping_cart</i>
                    <div style="display:flex;margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">
                        <select class="select2 browser-default" style="width: 100%;" name="shoplist" id="editshoplist"></select>
                        <label for="editshoplist">{{ __('messages.Shop Name') }}</label>
                    </div>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">description</i>
                    <label for="editdescription">{{ __('messages.Description') }}</label>
                    <input type="text" name="description" id="editdescription" >
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">branding_watermark</i>
                    <label for="editbrand">{{ __('messages.Brand') }}</label>
                    <input type="text" name="brand" id="editbrand" >
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">shop</i>
                    <label for="editsku">SKU</label>
                    <input type="text" name="sku" id="editsku">
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">confirmation_number</i>
                    <label for="editpartno">{{ __('messages.Part No') }}.</label>
                    <input type="text" name="partno" id="editpartno">
                </div>                   
                <div class="input-field">
                    <i class="material-icons prefix">attach_money</i>
                    <label for="editprice">{{ __('messages.Price') }}</label>
                    <input type="text" name="price" id="editprice">
                </div>                   
                <label class="text-black">
                    <input type="checkbox" id="editresetcheck">
                    <span>{{ __('messages.Upload') }} {{ __('messages.Image') }}</span>
                </label>
                <div class="input-field" id="editUrlImgDiv">
                    <i class="material-icons prefix">image</i>
                    <label for="editUploadUrl">{{ __('messages.Image') }}</label>
                    <input type="text" name="imageurl" id="editUploadUrl">
                    <div class="display-flex justify-content-center">
                        <img width="150" id="editUrlImage"></img>
                    </div>
                </div>                   
                
                <div class="input-field" id="editUploadImageDiv" style="display:none;">
                    <div class="display-flex justify-content-center">
                        <div class="image-div" style="width:auto;height:auto;">
                            <img src="{{ asset('imgs/upload_image.png') }}" width="150"  id="editSourceImg"></img>

                        <!-- <div class="logopreview"></div> -->
                            <button class="btn-floating waves-effect waves-light newimage-btn" id="select-edit-logo-files"><i class="material-icons">add_a_photo</i></button>
                            <div class="upfilewrapper" style="display:none;" id="editLogoImageDiv">
                                <input id="editUpload" type="file" name="image"  accept=".png,.jpeg,.jpg" data-default-file="" data-allowed-file-extensions='["png", "jpg", "jpeg"]'/>
                            </div>
                        </div>
                    </div>
                    <div class="error" id="errorimage">
                    </div>
                </div>
                <div class="card-action pl-0 pr-0 right-align">
                    <button class="btn-small waves-effect waves-light add-todo" type="submit" id="saveBtn">
                        <span>{{ __('messages.Save') }}</span>
                    </button>
                </div>
            </form>
            <!-- form start end-->
        </div>
    </div>
</div>
@endsection

@section('contentjs')
    @include('user.provider.material.jsindex')
@endsection