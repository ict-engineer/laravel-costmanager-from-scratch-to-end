@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/data-tables.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/page-account-settings.css') }}">

<!-- select2 -->
<link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2-materialize.css') }}" type="text/css">

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-todo.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>

<style>
    #uploadModal {
        max-width: 400px;
        overflow: hidden;
    }

    .cropper-container{
        margin: 0px;
        padding: 0px;
        max-height: 400px !important;
    }
    .imageout-bg{
        width: 100% !important;
        height: auto !important;
        max-height: 400px !important;
    }
    .modal-overlay {
        background: none;
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
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.Client') }} {{ __('messages.Employees') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.Client') }} {{ __('messages.Employees') }}
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
                            <h4 class="card-title" style="display:flex;align-items:center;"><i class="material-icons">verified_user</i>{{ __('messages.Employees') }}</h4>
                        </div>
                        <div class="col m6 s12 display-flex justify-content-end">
                            <a id="newEmployee" class="add-file-btn btn waves-effect waves-light border-round z-depth-4" href="javascript:void(0)">
                                <i class="material-icons">add</i>
                                <span class="hide-on-small-only">{{ __('messages.New') }} {{ __('messages.Employee') }}</span>
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
                                        <th>{{ __('messages.Employee') }}</th>
                                        <th>{{ __('messages.Name') }}</th>
                                        <th>{{ __('messages.Phone') }}</th>
                                        <th>{{ __('messages.Salary') }}</th>
                                        <th>{{ __('messages.Cycle') }}</th>
                                        <th>{{ __('messages.E-Mail Address') }}</th>
                                        <th>{{ __('messages.Role') }}</th>
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

<div class="todo-compose-sidebar" id="ajaxModal">
    <div class="card quill-wrapper">
        <div class="card-content pt-0">
            <div class="card-header display-flex">
                <h3 class="card-title mb-0" id="modalheader">{{ __('messages.NEW') }} {{ __('messages.EMPLOYEE') }}</h3>
                <div class="close close-icon">
                    <i class="material-icons">close</i>
                </div>
            </div>
            <div class="divider"></div>
            <div class="display-flex justify-content-center">
                <div class="image-div">
                <img src="{{ asset('imgs/user.png') }}" width="150" height="150" id="sourceImg"></img>
                <div class="preview"></div>
                <button class="btn-floating waves-effect waves-light newimage-btn" id="select-files"><i class="material-icons">add_a_photo</i></button>
                <div class="upfilewrapper" style="display:none;">
                        <input id="upfile" type="file"  accept=".png,.jpeg,.jpg" data-default-file="" data-allowed-file-extensions='["png", "jpg", "jpeg"]'/>
                    </div>
                </div>
            </div>
            <!-- form start -->
            <form role="form" id="sendForm" class="mt-1">
                @csrf
                <input type="hidden" name="typeid" id="typeid">
                <input type="hidden" name="image" id="imageurl">
                <div class="input-field">
                    <i class="material-icons prefix">perm_identity</i>
                    <label for="name">{{ __('messages.Name') }}</label>
                    <input type="text" name="name" class="validate mainInfoInput"  id="name" >
                    <div class="error" id="errorname">
                        </div>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">phone</i>
                    <div style="display:flex;margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">
                        <select name="countryCode" id="countrycodeSel" style="width:100px;" class="select2 browser-default">
                            @include('user.components.phoneprefix')
                        </select>
                        <label for="countrycodeSel">{{ __('messages.Phone Number') }}</label>
                        <input type="text"  class="validate mainInfoInput" name="phone" id="phone"  data-inputmask='"mask": "(999) 999-9999"'>
                    </div>
                    <div class="error" id="errorphone">
                    </div>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">attach_money</i>
                    <label for="salary">{{ __('messages.Salary') }}</label>
                    <input type="text" class="validate mainInfoInput"  name="salary" id="salary">
                    <div class="error" id="errorsalary">
                        </div>
                </div>
                <div class="input-field">
                  <i class="material-icons prefix">date_range</i>
                  <div style="margin-left: 3rem">
                    <label for="cycle">{{ __('messages.Cycle') }}</label>
                    <select name="cycle"  class="select2 browser-default" id="cycle" style="width:100%;">
                        <option value="Monthly">{{ __('messages.Monthly') }}</option>
                        <option value="Weekly">{{ __('messages.Weekly') }}</option>
                        <option value="Hourly">{{ __('messages.Hourly') }}</option>
                    </select>
                  </div>
                </div>         

                <div class="display-flex justify-content-between">
                    <label class="text-black">
                        <input type="checkbox" id="systemuser" name="systemuser">
                        <span>{{ __('messages.System User') }}</span>
                    </label>
                    <button class="btn-small btn-light-pink" id="inviteBtn" value="Invite">{{ __('messages.Invite') }}</button>
                </div>
                <div id="systemdiv" style="display:none;">
                    <div class="input-field">
                    <i class="material-icons prefix">verified_user</i>
                    <div style="margin-left: 3rem">
                        <label for="role">{{ __('messages.Role') }}</label>
                        <select name="role" class="select2 browser-default" id="role" style="width:100%;">
                            <option value="Administrative">{{ __('messages.Administrative') }}</option>
                            <option value="Sales">{{ __('messages.Sales') }}</option>
                        </select>
                        
                    </div>
                    </div>                     
                    <div class="input-field">
                        <i class="material-icons prefix">email</i>
                        <label for="email">{{ __('messages.E-Mail Address') }}</label>
                        <input type="text" class="validate mainInfoInput"  name="email" id="email">
                        <div class="error" id="erroremail">
                        </div>
                    </div>                   
                </div>
                
                <div class="card-action pl-0 pr-0 right-align">
                    <button class="btn-small waves-effect waves-light add-todo" id="saveBtn">
                        <span>{{ __('messages.Add') }}</span>
                    </button>
                </div>
            </form>
            
            <!-- form start end-->
        </div>
    </div>
</div>

<div class="modal" id="uploadModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalheader">{{ __('messages.Upload') }} {{ __('messages.Image') }}</h6>
            </div>
            
            <div class="divider mt-1 mb-1"></div>
            <div class="modal-body">
              <div class="imageout-bg">
                <img id="image" style="width:100%;">
              </div>
              
              <div class="divider mb-3"></div>
              <div  class="mb-3 user-edit-btns display-flex  justify-content-end ">
                  <button type="submit" class="btn-small indigo" id="usaveBtn" value="create">{{ __('messages.Upload') }}</button>
                  <button class="btn-small btn-light-pink" id="ucancelBtn" style="margin-left:10px;" value="cancel">{{ __('messages.Cancel') }}</button>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentjs')
@include('user.client.employee.js')
@endsection
