@extends('layouts.layout')
   
@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2-materialize.css') }}" type="text/css">
<style>
    /* Set the size of the div element that contains the map */
  #map {
    height: 400px;  /* The height is 400 pixels */
    width: 100%;  /* The width is the width of the web page */
    }
</style>
@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.Edit') }} {{ __('messages.Shop') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Provider') }} {{ __('messages.Shops') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.Edit') }} {{ __('messages.Shop') }}
    </li>
</ol>
@endsection
@section('content')
<div class="tabs-vertical mt-1 section">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
            <div class="card-content">
                <form role="form" id="quickForm" action="{{ route('user.providershops.update',$shop->id) }}" method="POST" class="mt-1">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="lat" id="lat" value="{{ old( 'lat', $shop->lat) }}">
                    <input type="hidden" name="lng" id="lng" value="{{ old( 'lng', $shop->lng) }}">

                    <div class = "row">
                        <div class="col l6 s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input type="text"  class="validate" name="name" id="name"  value="{{ old( 'name', $shop->name) }}" >
                                    <label for="name">{{ __('messages.Name') }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">location_city</i>
                                    <input type="text"  class="validate" name="addline1" id="addline1"  value="{{ old( 'addline1', $shop->addline1) }}" >
                                    <label for="addline1">{{ __('messages.Address Line') }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">location_on</i>
                                    <div style="margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">
                                        <select name="country" id="country_selector" style="width:100%;" class="select2 browser-default">
                                        @include('user.components.country')
                                        </select>
                                        <label for="country_selector" style="margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">{{ __('messages.Country') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">code</i>
                                    <input type="text"  class="validate" name="cp" id="cp"  value="{{ old( 'cp', $shop->cp) }}" >
                                    <label for="cp">C.P.</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">attach_money</i>
                                    <div style="margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">
                                        @include('user.components.currency')
                                        <label for="currency" style="margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">{{ __('messages.Currency') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col l6 s12">
                            <div id="map"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 display-flex justify-content-end mt-3">
                            <button type="submit" class="btn indigo" style="margin-right:1rem;">{{ __('messages.Edit') }}</button>
                            <a href="/user/providershops" type="button" class="btn btn-light">{{ __('messages.Cancel') }}</a>
                        </div>
                    </div>        
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('contentjs')
@include('user.provider.shop.js')
@endsection