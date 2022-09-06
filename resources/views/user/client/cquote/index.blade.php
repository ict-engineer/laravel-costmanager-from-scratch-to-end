@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/data-tables.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('custom_components/cquote/css/main.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    #mapModel {
        overflow: hidden;
    }
    #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
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
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.'.$type.'s') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.'.$type.'s') }}
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
                            <h4 class="card-title" style="display:flex;align-items:center;"><i class="material-icons">account_balance</i>{{ __('messages.'.$type.'s') }}</h4>
                        </div>
                        <div class="col m4 s12">
                        <form class="form" id="filterForm" method="GET">
                            <div class="display-flex">
                                <label for="fromDate">{{ __('messages.From') }}</label>
                                <input type="text" class="" id="fromDate" name="fromDate" style="border-bottom:0px solid white;">
                                <label for="toDate">{{ __('messages.To') }}</label>
                                <input type="text" class="" id="toDate" name="toDate" style="border-bottom:0px solid white;">
                            </div>
                        </form>
                        </div>
                        <div class="col m2 s12" style="padding-top: 0.5%;">
                            <span id="totalSum">Total:</span>
                        </div>
                        <div class="col m3 s12 display-flex justify-content-end align-items-center">
                            @if($type == 'Quote')
                                <a class="btn waves-effect waves-light border-round z-depth-4" href="{{ route('user.clientquotes.create') }}" id="newcquote">
                            @else
                                <a class="btn waves-effect waves-light border-round z-depth-4" href="{{ route('user.clientinvoices.create') }}" id="newcquote">
                            @endif
                                <i class="material-icons prefix">add</i>
                                <span class="hide-on-small-only">{{ __('messages.New') }} {{ __('messages.'.$type) }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="divider mb-1 mt-1"></div>
                    <div class="row">
                        <div class="col s12">
                            <table id="page-length-option" class="display cquote-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.Date') }}</th>
                                        <th>No</th>
                                        <th>{{ __('messages.Client') }}</th>
                                        <th>{{ __('messages.Project') }}</th>
                                        <th>{{ __('messages.Total') }}</th>
                                        <th>{{ __('messages.Address Line') }}</th>
                                        <th>{{ __('messages.Status') }}</th>
                                        <th>{{ __('messages.Action') }}</th>
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

<div class="modal fade" id="mapModel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="map"></div>
                <div class="display-flex justify-content-end mt-3">
                    <button class="btn-small btn-light-pink" id="cancelMapBtn" >{{ __('messages.Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentjs')
@include('user.client.cquote.jsindex')
@endsection