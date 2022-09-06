@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/data-tables.css') }}">


<style>
.chip > .chip-prefix {
    float: left;
    width: 32px;
    height: 32px;
    margin: 4px 0px 0 -5px;
    border-radius: 50%;
}
@media (min-width: 600px)
    {
            .btn i {
            float: left;
            margin-right: 8px;
        }
    }
@media only screen and (min-width: 1800px) {
    #filter-panel {
        float: left;
        box-sizing: border-box;
        min-height: 1px;
        right: auto;
        left: auto;
        width: 16.7%;
        margin-left: auto;
        padding: 0 0.7rem;
    }
    #table-panel {
        float: left;
        box-sizing: border-box;
        min-height: 1px;
        right: auto;
        left: auto;
        width: 83.3%;
        margin-left: auto;
        padding: 0 0.7rem;
    }
}


@media only screen and (min-width: 900px) {
    #filter-panel {
        float: left;
        box-sizing: border-box;
        min-height: 1px;
        right: auto;
        left: auto;
        width: 30%;
        margin-left: auto;
        padding: 0 0.7rem;
    }
    #table-panel {
        float: left;
        box-sizing: border-box;
        min-height: 1px;
        right: auto;
        left: auto;
        width: 70%;
        margin-left: auto;
        padding: 0 0.7rem;
    }
}
@media only screen and (min-width: 1200px) {
    #filter-panel {
        float: left;
        box-sizing: border-box;
        min-height: 1px;
        right: auto;
        left: auto;
        width: 23%;
        margin-left: auto;
        padding: 0 0.7rem;
    }
    #table-panel {
        float: left;
        box-sizing: border-box;
        min-height: 1px;
        right: auto;
        left: auto;
        width: 77%;
        margin-left: auto;
        padding: 0 0.7rem;
    }
}
@media only screen and (min-width: 1500px) {
    #filter-panel {
        float: left;
        box-sizing: border-box;
        min-height: 1px;
        right: auto;
        left: auto;
        width: 20%;
        margin-left: auto;
        padding: 0 0.7rem;
    }
    #table-panel {
        float: left;
        box-sizing: border-box;
        min-height: 1px;
        right: auto;
        left: auto;
        width: 80%;
        margin-left: auto;
        padding: 0 0.7rem;
    }
}

tbody > tr:hover {
    background-color: #E5E5Ef !important;
}
</style>
@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.Consult Materials') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.Consult Materials') }}
    </li>
</ol>
@endsection
@section('content')
<div class="tabs-vertical mt-1 section section-data-tables">
    <div class=row>
        <div id="filter-panel">
            <div class="card">
                <div class="card-content">
                    <div class="display-flex align-items-center">
                        <i class="material-icons">filter_list</i><h5 style="margin-left:10px;">{{ __('messages.Filter') }}</h5>
                    </div>
                    <div class="divider mt-1 mb-10"></div>
                    <div class="input-field">
                        <i class="material-icons prefix">search</i>
                        <input type="text" id="filter-keyword" placeholder="{{ __('messages.Type and press enter') }}."></input>
                        <label for="filter-keyword">{{ __('messages.Keyword') }}</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">groups</i>
                        <input type="text" class="autocomplete" autocomplete="off" id="filter-provider" style="display:inline;">
                        <label for="filter-provider">{{ __('messages.Provider') }}</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">branding_watermark</i>
                        <input type="text" class="autocomplete" autocomplete="off" id="filter-brand">
                        <label for="filter-brand">{{ __('messages.Brand') }}</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">shop</i>
                        <input type="text" class="autocomplete" autocomplete="off" id="filter-sku"  >
                        <label for="filter-sku">Sku</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">confirmation_number</i>
                        <input type="text" class="autocomplete" autocomplete="off" id="filter-partno" >
                        <label for="filter-partno">{{ __('messages.Part No') }}</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">location_on</i>
                        <select id="filter-radius" style="width: 100% !important;">
                            <option value="Search Radius" disabled selected>{{ __('messages.Search Radius') }}</option>\
                            <option value="1km {{ __('messages.or Less') }}">1km {{ __('messages.or Less') }}</option>
                            <option value="1~5km">1~5km</option>
                            <option value="5~10km">5~10km</option>
                            <option value="10~20km">10~20km</option>
                            <option value="20km {{ __('messages.or More') }}">20km {{ __('messages.or More') }}</option>
                        </select>
                        <label for="filter-radius">{{ __('messages.Search Radius') }}</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="table-panel">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12">
                            <div id="filter-list">
                            </div>
                            <div class="display-flex justify-content-between align-items-center">
                                
                                <div class="display-flex justify-content-end align-items-center">
                                    <span>{{ __('messages.Show') }}</span>
                                    <select id="perpageSelect" class="browser-default" style="display: inline-block;width: auto;height: auto;">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="50">50</option>
                                    </select>
                                    <span>{{ __('messages.Materials') }}</span>
                                </div>
                                <div style="display:flex;">
                                    <span>{{$materials->total()}} {{ __('messages.Materials') }}</span>
                                    <form method="get" action="/user/getConsultMaterials" id="downloadForm" style="display:none;">
                                        <input id="keywordfilters1" name="keywordfilters"></input>
                                        <input id="providerfilters1" name="providerfilters"></input>
                                        <input id="brandfilters1" name="brandfilters"></input>
                                        <input id="skufilters1" name="skufilters"></input>
                                        <input id="partnofilters1" name="partnofilters"></input>
                                        <input id="radiusfilters1" name="radiusfilters"></input>
                                    </form>
                                    <a class="btn waves-effect waves-light border-round z-depth-4 mr-1" href="javascript:void(0)" id="downloadList">
                                        <i class="material-icons">file_download</i>
                                        <span class="hide-on-small-only">{{ __('messages.Download') }} {{ __('messages.List') }}</span>
                                    </a>
                                </div>
                                
                            </div>
                            <table id="data-table-simple" class="display">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.Description') }}</th>
                                        <th>{{ __('messages.Shop Name') }}</th>
                                        <th>{{ __('messages.Brand') }}</th>
                                        <th>Sku</th>
                                        <th>{{ __('messages.Part No') }}.</th>
                                        <th>{{ __('messages.Price') }}</th>
                                        <th>{{ __('messages.Distance') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($materials as $material)
                                    <tr>
                                        <td>
                                            <p>{{ $material->description }}</p>
                                            @if($material->image != null && $material->image != '')
                                                <img style="display:none;" src="{{ $material->image }}"  alt="Image" width="100" height="100">
                                            @endif
                                        </td>
                                        <td>{{ $material->shopName }}</td>
                                        <td>{{ $material->brand }}</td>
                                        <td>{{ $material->sku }}</td>
                                        <td>{{ $material->partno }}</td>
                                        <td>{{ $material->price }} {{ $material->currency }}</td>
                                        <td>{{ $dists[$material->shop_id] }}km</td>
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
        <form id="filterForm" method="GET" style="display:none">
            <input id="keywordfilters" name="keywordfilters"></input>
            <input id="providerfilters" name="providerfilters"></input>
            <input id="brandfilters" name="brandfilters"></input>
            <input id="skufilters" name="skufilters"></input>
            <input id="partnofilters" name="partnofilters"></input>
            <input id="radiusfilters" name="radiusfilters"></input>
            <input id="perpage" name='perpage'></input>
        </form>
    </div>
</div>

@endsection

@section('contentjs')
    @include('user.client.consult_material.jsindex')
@endsection