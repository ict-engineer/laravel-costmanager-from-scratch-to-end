@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/dashboard.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    /* Set the size of the div element that contains the map */
  #map {
    height: 400px;  /* The height is 400 pixels */
    width: 100%;  /* The width is the width of the web page */
    }
    .sweet-alert p {
        text-align: left !important;
    }
</style>
@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.Dashboard') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.Dashboard') }}
    </li>
</ol>
@endsection
@section('content')
<div class="section">
    <div id="card-stats" class="pt-0">
        <div class="row">
            <div class="col s12 m6 l6 xl3">
                <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">shopping_cart</i>
                                <p>{{ __('messages.Shops') }}</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mt-10 white-text">{{ $shopCount }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">thumb_up</i>
                                <p>{{ __('messages.Materials') }}</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mt-10 white-text">{{ $materialCount }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6 xl9">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentjs')
<script src="{{ asset('/app-assets/js/scripts/dashboard-ecommerce.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
    function initMap() {
        // The location of Uluru
        var map;

        result = {lat:0, lng: 0};
        // The map, centered at Uluru
        map = new google.maps.Map(
            document.getElementById('map'), {zoom: 2, center: result});
        // The marker, positioned at Uluru
        
        var tmpValue = '';
        var shops = {!! $shops ?? 'tmpValue' !!};
        for(i in shops)
        {
            var marker;
            result = {lat:shops[i].lat, lng: shops[i].lng};
            marker = new google.maps.Marker({position: result, map: map});
        }
        if(shops.length)
        {
            result = {lat:shops[0].lat, lng: shops[0].lng};
            map.setCenter(result);
            map.setZoom(2);
        }
    }
</script>
<script defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqsYlbvunG8q26BV66NAVX3pGEl3lIgdI&libraries=places&callback=initMap">
</script>
@endsection
