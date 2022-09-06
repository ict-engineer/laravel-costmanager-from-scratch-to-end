@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/data-tables.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

<style>
    #ajaxModel {
        max-width: 400px;
        overflow: hidden;
        overflow-y:auto;
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
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.Projects') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.Projects') }}
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
                            <h4 class="card-title" style="display:flex;align-items:center;"><i class="material-icons">apps</i>{{ __('messages.Projects') }}</h4>
                        </div>
                        <div class="col m6 s12 display-flex justify-content-end">
                            <a class="add-file-btn btn waves-effect waves-light border-round z-depth-4" href="javascript:void(0)" id="newproject">
                                <i class="material-icons">add</i>
                                <span class="hide-on-small-only">{{ __('messages.New') }} {{ __('messages.Project') }}</span>
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
                                        <th>{{ __('messages.Name') }}</th>
                                        <th>{{ __('messages.Client') }}</th>
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

<div class="modal fade" id="ajaxModel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalheader">{{ __('messages.New') }} {{ __('messages.Project') }}</h6>
            </div>
            
            <div class="divider mt-5 mb-5"></div>
            <div class="modal-body">
                <form id="sendForm" name="sendForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="typeid" id="typeid">
                    <div class="input-field">
                        <i class="material-icons prefix">supervisor_account</i>
                        <input type="text" name="client" id="client" autocomplete="off" class="autocomplete mainInfoInput">
                        <label for="client">{{ __('messages.Client') }}</label>
                        <div class="error" id="errorclient"></div>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">info_outline</i>
                        <label for="name">{{ __('messages.Name') }}</label>
                        <input class="validate mainInfoInput" type="text" name="name" id="name" >
                        <div class="error" id="errorname">
                        </div>
                    </div>
                    <div  class="mt-3 mb-3 user-edit-btns display-flex  justify-content-end ">
                        <button type="submit" class="btn-small indigo" id="saveBtn" value="create">{{ __('messages.Add') }}</button>
                        <button class="btn-small btn-light-pink" id="cancelBtn" style="margin-left:10px;" value="cancel">{{ __('messages.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('contentjs')
@include('user.client.project.jsindex')
@endsection