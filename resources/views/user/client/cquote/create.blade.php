@extends('layouts.layout')
   
@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2-materialize.css') }}" type="text/css">
<link href="https://rawgit.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<link rel="stylesheet" href="{{ asset('custom_components/function_table/css/main.css') }}" type="text/css">

@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.New') }} {{ __('messages.'.$type) }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.'.$type.'s') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.New') }} {{ __('messages.'.$type) }}
    </li>
</ol>
@endsection
@section('content')
<div class="tabs-vertical mt-1 section">
    <div id="editQuoteDiv">
        <div style="width:100%;">
            <div class="card-panel">
            <div class="card-content">
                <form id="sendForm" class="mt-1">
                    @csrf
                    <input type="hidden" name="quoteid" id="quoteid">
                    <div class = "row">
                        <div class="input-field col l12">
                            <div class="display-flex">
                                <span style="display:flex;align-items: center;min-width: 9.5rem;height: 46px">{{ __('messages.'.$type) }} {{ __('messages.Number') }}</span>
                                <input type="text" class="quoteInfoInput" style='max-width: 10rem;' name="quoteNumber" id="quoteNumber"  inputmode="numeric" value="{{ old( 'quoteNumber') }}" placeholder="{{ __('messages.'.$type) }} {{ __('messages.Number') }}">
                                <i class="material-icons setEditable">edit</i>    
                            </div>
                        </div>
                        <div class="col l12">
                            <div class="error" id="errorquoteNumber" style="text-align:left;margin-left:9.5rem;"></div>
                        </div>
                    </div>
                    <div class="divider mt-1 mb-1"></div>
                    <div class = "row">
                        <div class="input-field col l6 m6 s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="quoteInfoInput" name="client" id="client" class="autocomplete" autocomplete="off" value="{{ old( 'client') }}" placeholder="{{ __('messages.Client') }}">
                            <div class="error" id="errorclient"></div>
                        </div>
                        <div class="input-field col l6 m6 s12">
                            <i class="material-icons prefix">groups</i>
                            <input type="text" class="quoteInfoInput" name="companyname" id="companyname"  value="{{ old( 'companyname') }}" placeholder="{{ __('messages.Company Name') }}">
                            <div class="error" id="errorcompanyname">  </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class="input-field col l6 m6 s12">
                            <i class="material-icons prefix">phone</i>
                            <input type="text" class="quoteInfoInput" name="phone" id="phone"  data-inputmask='"mask": "(999) 999-9999"'  value="{{ old( 'phonetmp') }}">
                            <div class="error" id="errorphone"></div>
                        </div>
                        
                        <div class="input-field col l6 m6 s12">
                            <i class="material-icons prefix">email</i>
                            <input type="text" class="quoteInfoInput"  name="email" id="email"  value="{{ old( 'email') }}" placeholder="{{ __('messages.E-Mail Address') }}">
                            <div class="error" id="erroremail"></div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class="input-field col l6 m6 s12">
                            <i class="material-icons prefix">info_outline</i>
                            <div name="project" class="quoteInfoInput" id="project" value="{{ old( 'project') }}" placeholder="{{ __('messages.Project') }}"></div>
                            <div class="error" id="errorproject"></div>
                        </div>
                        <div class="input-field col l6 m6 s12">
                            <i class="material-icons prefix">location_city</i>
                            <input type="text"  class="validate" name="addline" id="addline" value="{{ old( 'addline') }}" placeholder="{{ __('messages.Address Line') }}">
                            <div class="error" id="erroraddline"></div>
                        </div>
                    </div>
                    <div class="divider mb-1 mt-1"></div>
                    <fieldset id="filterRow" style="display:none;">
                        <legend>Materials Search Filter</legend>
                        <div class="row mt-1 mb-1">
                            <div class='col m4 s12'>
                                <div class="input-field">
                                    <i class="material-icons prefix">sort</i>
                                    <select id="filter-sort" style="width: 100% !important;">
                                        <option value="Closest">Closest</option>
                                        <option value="Cheapest">Cheapest</option>
                                        <option value="Cheapest and Closest">Cheapest and Closest</option>
                                    </select>
                                    <label for="filter-sort">{{ __('messages.Sort By') }}</label> 
                                </div>
                            </div>
                            <div class='col m4 s12'>
                                <div class="input-field">
                                    <i class="material-icons prefix">groups</i>
                                    <div style="display:flex;margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">
                                        <select class="select2 browser-default" multiple="multiple" id="filter-provider">
                                        </select>
                                        <label for="filter-provider">{{ __('messages.Provider') }}</label> 
                                    </div>
                                </div>
                            </div>
                            <div class='col m4 s12'>
                                <div class="input-field">
                                    <div class="display-flex align-items-center" style="height: 3rem;">
                                        <div class="switch">
                                            <label>
                                                <input type="checkbox" id="filter-image">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                        <span style="width:6.5rem;">{{ __('messages.Show') }} {{ __('messages.Image') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div id="fMain">
                        <div id="fGroups">
                            <div class="fGroup fttBlue">
                            <table class="table ftGroup">
                                <thead>
                                <th class="ftGSelector">
                                    <a class='dropdown-trigger btn dropdown-btn' href='#' id="dropbtn1" data-target='dropdown1'><i class="material-icons">arrow_drop_down</i></a>
                                    <ul id='dropdown1' class='dropdown-content'>
                                        <li><a href="#" class="ftCollapse">{{ __('messages.Expand') }}</a></li>
                                        <li><a href="#" class="ftDelete">{{ __('messages.Delete') }}</a></li>
                                        <li><a href="#" class="addNewGroup">{{ __('messages.New') }} {{ __('messages.Group') }}</a></li>
                                        <li><a href="#" class="addService">{{ __('messages.Add') }} {{ __('messages.Services') }}</a></li>
                                        <li><a href="#" class="addEmployee">{{ __('messages.Add') }} {{ __('messages.Employees') }}</a></li>
                                        <li class="divider" tabindex="-1"></li>
                                        <li><a href="#" class="fttBlue">{{ __('messages.Blue') }} {{ __('messages.Theme') }}</a></li>
                                        <li><a href="#" class="fttPurple">{{ __('messages.Purple') }} {{ __('messages.Theme') }}</a></li>
                                        <li><a href="#" class="fttRed">{{ __('messages.Pink') }} {{ __('messages.Theme') }}</a></li>
                                        <li><a href="#" class="fttGreen">{{ __('messages.Green') }} {{ __('messages.Theme') }}</a></li>
                                        <li><a href="#" class="fttOrange">{{ __('messages.Orange') }} {{ __('messages.Theme') }}</a></li>
                                    </ul>
                                </th>
                                <th colspan="2">
                                    <div class="display-flex">
                                        <input type="text" class="font1 invisInput ftTitle" value="Concept" placeholder="Concept">
                                        <i class="material-icons setEditable">edit</i>  
                                    </div>
                                </th>
                                <th class="font1">{{ __('messages.Quantity') }}</th>
                                <th class="font1">{{ __('messages.Cost') }}</th>
                                <th class="font1">{{ __('messages.Margin') }}</th>
                                <th class="font1">{{ __('messages.Total') }}</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="ftISelector">
                                        <a class='dropdown-trigger btn indigo dropdown-btn' id="dropbtn2" href='#' data-target='dropdownchild1'><i class="material-icons">arrow_drop_down</i></a>
                                        <ul id='dropdownchild1' class='dropdown-content'>
                                            <li style="display: none;"><a href="#" class="ftCollapse">{{ __('messages.Expand') }} {{ __('messages.Materials') }}</a></li>
                                            <li><a href="#" class="ftAddSIRemote">{{ __('messages.Add') }} {{ __('messages.Material') }}</a></li>
                                            <li><a href="#" class="ftDelete">{{ __('messages.Delete') }} {{ __('messages.Item') }}</a></li>
                                        </div>
                                    </td>
                                    <td ></td>
                                    <td>
                                    <img src="{{ asset('custom_components/function_table/img/fav_positive.svg') }}" class="ftOFIcon">
                                    <input type="text" class="font1 invisInput" value="Item 1">
                                    </td>
                                    <td>
                                    <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Quantity" value="1">
                                    </td>
                                    <td>
                                    <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Cost" value="$0">
                                    </td>
                                    <td>
                                    <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Margin" value="0.00%">
                                    </td>
                                    <td>
                                    <input type="text" inputmode="numeric" class="font1 invisInput itemTotal" placeholder="Total" value="$0.00">
                                    </td>
                                </tr>
                                <tr class="ftSubitems" style="display: none;">
                                    <td colspan="7">
                                    <div class="ftSIDiv">
                                        <table class="table ftSITable">
                                        <thead>
                                            <th style="width: 0.001% !important"></th>
                                            <th class="font1">{{ __('messages.Material') }}</th>
                                            <th class="font1">{{ __('messages.Provider') }}</th>
                                            <th class="font1">{{ __('messages.Quantity') }}</th>
                                            <th class="font1">{{ __('messages.Cost') }}</th>
                                            <th class="font1">{{ __('messages.Total') }}</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        </table>
                                    </div>
                                    </td>
                                </tr>
                                <tr class="ftNew">
                                    <td class="ftISelector"><div><img src="{{ asset('custom_components/function_table/img/tri_selector_black.png') }}"></div></td>
                                    <td class="ftTab"></td>
                                    <td class="ftField">
                                    <input type="text" class="font1 invisInput" placeholder="+ {{ __('messages.Add') }}">
                                    </td>
                                    <td></td><td></td><td></td>
                                    <td>
                                    <div class="ftNewBtn">+</div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
        <div style="min-width: 310px;" id="rightPanel">
            <div class="card-panel">
            <div class="card-content">
            <div class="row">
                <div class="col s12">
                    <div class="display-flex justify-content-between">
                        <div class="display-flex align-items-center">
                            <div class="switch">
                                <label>
                                    <input type="checkbox" id="discountCheck">
                                    <span class="lever"></span>
                                </label>
                            </div>
                            <span style="width:6.5rem;">{{ __('messages.Discount') }}</span>
                        </div>
                        <input type="text" style="height: 2rem;width:4rem; text-align: center;"  inputmode="numeric" value="0%" id="discountInput"></input>
                    </div>
                    <div class="display-flex justify-content-between ">
                        <div class="display-flex align-items-center">
                            <div class="switch">
                                <label>
                                    <input type="checkbox" id="unpreventedCheck">
                                    <span class="lever"></span>
                                </label>
                            </div>
                            <span style="width:6.5rem;">{{ __('messages.Unprevented') }}</span>
                        </div>
                        <input type="text" style="height: 2rem;width:4rem; text-align: center;"  inputmode="numeric" value="0%" id="unpreventedInput"></input>
                    </div>
                    <div class="display-flex justify-content-between ">
                        <div class="display-flex align-items-center">
                            <div class="switch">
                                <label>
                                    <input type="checkbox" id="shopdaysCheck">
                                    <span class="lever"></span>
                                </label>
                            </div>
                            <span style="width:6.5rem;">{{ __('messages.Shop Days') }}</span>
                        </div>
                        <input type="text" style="height: 2rem;width:4rem; text-align: center;"  inputmode="numeric" value="0" id="shopdaysInput"></input>
                    </div>
                    <div class="display-flex justify-content-between ">
                        <div class="display-flex align-items-center">
                            <div class="switch">
                                <label>
                                    <input type="checkbox" id="advanceCheck">
                                    <span class="lever"></span>
                                </label>
                            </div>
                            <span style="width:6.5rem;">{{ __('messages.Advance') }}</span>
                        </div>
                        <input type="text" style="height: 2rem;width:4rem; text-align: center;"  inputmode="numeric" value="0%" id="advanceInput"></input>
                    </div>
                    <div class ="divider mt-5 mb-5"></div>
                </div>
                
                <div class="col s12">
                    <li class="display-flex justify-content-between">
                        <span class="invoice-subtotal-title">{{ __('messages.Items') }}</span>
                        <h6 class="invoice-subtotal-value" id="sumItems">$0.00</h6>
                    </li>
                    <li class="display-flex justify-content-between">
                        <span class="invoice-subtotal-title">{{ __('messages.External Services') }}</span>
                        <h6 class="invoice-subtotal-value" id="sumServices">$0.00</h6>
                    </li>
                    <li class="display-flex justify-content-between">
                        <span class="invoice-subtotal-title">{{ __('messages.Employees') }}</span>
                        <h6 class="invoice-subtotal-value" id="sumEmployees">$0.00</h6>
                    </li>
                    <li class="display-flex justify-content-between">
                        <span class="invoice-subtotal-title">{{ __('messages.Shop Days') }}</span>
                        <h6 class="invoice-subtotal-value" id="sumShopdays">$0.00</h6>
                    </li>
                    <div class="divider mt-1 mb-1"></div>
                    <li class="display-flex justify-content-between">
                        <span class="invoice-subtotal-title">{{ __('messages.SubTotal') }}</span>
                        <h6 class="invoice-subtotal-value" id="sumSubtotal">$0.00</h6>
                    </li>
                    <li class="display-flex justify-content-between">
                        <span class="invoice-subtotal-title">{{ __('messages.Unprevented') }}</span>
                        <h6 class="invoice-subtotal-value" id="sumUnprevented">$0.00</h6>
                    </li>
                    <li class="display-flex justify-content-between">
                        <span class="invoice-subtotal-title">{{ __('messages.Discount') }}</span>
                        <h6 class="invoice-subtotal-value" id="sumDiscount">-$0.00</h6>
                    </li>
                    <div class="divider mt-1 mb-1"></div>
                    <li class="display-flex justify-content-between">
                        <span class="invoice-subtotal-title">{{ __('messages.Total') }}</span>
                        <h6 class="invoice-subtotal-value" id="sumTotal">$0.00</h6>
                    </li>
                    <li class="display-flex justify-content-between">
                        <span class="invoice-subtotal-title">{{ __('messages.Advance') }}</span>
                        <h6 class="invoice-subtotal-value" id="sumAdvance">$0.00</h6>
                    </li>
                    <a href="javascript:void(0)" id="previewBtn" class="btn btn-block waves-effect waves-light">{{ __('messages.Preview') }}</a>
                    <div class="row mt-3">
                        <div class="col s6"  style="padding: 0px 10.875px;">
                            <button type="submit" class="btn btn-block indigo btnSave">{{ __('messages.Create') }}</button>
                        </div>
                        <div class="col s6" style="padding: 0px 10.875px;">
                            @if($type == 'Quote')
                                <a href="/user/clientquotes" type="button" id="cancelBtn" class="btn btn-block btn-light-pink">{{ __('messages.Cancel') }}</a>
                            @else
                                <a href="/user/clientinvoices" type="button" id="cancelBtn" class="btn btn-block btn-light-pink">{{ __('messages.Cancel') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
    </div>
    <div id="previewQuoteDiv" style="display:none;">
        <div style="padding-right: 0px;width: 100%;">
            <div class="card">
                <div class="card-content print-area">
                        <div class="display-flex justify-content-between">
                            <img id="quoteLogoImage"></img>
                            <span class="big-font bold-weight-font"  style="margin-top: auto;" id="dateText"></span>
                        </div>
                        <div class="divider mb-1" style="background-color: rgb(33, 120, 135); height: 4px;"></div>
                    <div class="quoteInfo mb-5">
                        <div class="display-flex align-items-center justify-content-between">
                            <span class="big-font bold-weight-font" id="preClient"></span>
                            <span class="big-font bold-weight-font" id="preQuoteNumber"></span>
                        </div>
                        <div class="display-flex align-items-center">
                            <span class="big-font" id="prePhone"></span>
                        </div>
                        <div class="display-flex align-items-center">
                            <span class="big-font" id="preCompany"></span>
                        </div>
                        <div class="display-flex align-items-center">
                            <span class="big-font" id="preEmail"></span>
                        </div>
                        <div class="display-flex align-items-center">
                            <span class="big-font" id="preAddress"></span>
                        </div>
                        <div class="display-flex align-items-center">
                            <span class="big-font" id="preProject"></span>
                        </div>
                    </div>
                    <div id="preMain">
                    </div>
                    <div class = "subtotal display-flex justify-content-end">
                        <div style="min-width: 300px; max-width: 400px;">
                            <li class="display-flex justify-content-between">
                                <span class="invoice-subtotal-title-preview bold-weight-font">{{ __('messages.SubTotal') }}</span>
                                <h6 class="invoice-subtotal-value bold-weight-font" id="previewSubtotal">$0.00</h6>
                            </li>
                            <li class="display-flex justify-content-between" id="discountRow">
                                <span class="invoice-subtotal-title-preview bold-weight-font"  id="preDiscountHeader">{{ __('messages.Discount') }}</span>
                                <h6 class="invoice-subtotal-value bold-weight-font" id="previewDiscount">-$0.00</h6>
                            </li>
                            <li class="display-flex justify-content-between">
                                <span class="invoice-subtotal-title-preview bold-weight-font big-font">{{ __('messages.Total') }}</span>
                                <h6 class="invoice-subtotal-value big-font bold-weight-font" id="previewTotal">0.00$</h6>
                            </li>
                            <li class="display-flex justify-content-between" id="advanceRow">
                                <span class="invoice-subtotal-title"  id="preAdvanceHeader" style="justify-content: flex-end; width: 110px;">{{ __('messages.Advance') }}</span>
                                <h6 class="invoice-subtotal-value" id="previewAdvance">0.00$</h6>
                            </li>
                        </div>
                    </div>
                    <div style="text-align:right;margin-top:5px;">
                        <span style="width: 100%" id="totalText"></span>
                    </div>
                    <div style="text-align: center;margin-top: 3rem;">
                        <span class="bold-weight-font" id="footerText"></span>
                    </div>
                </div>
            </div>
        </div>
        <div style="min-width: 350px;" id="previewRightPanel">
            <div class="card action-wrapper">
                <div class="card-content">
                    <div class="invoice-action-btn mt-3 mb-3">
                        <a href="javascript:void(0)" id="editQuoteBtn" class="btn-block btn btn-light-blue waves-effect waves-light">
                            <span>{{ __('messages.Edit') }} {{ __('messages.'.$type) }}</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn mt-3 mb-3">
                        <a href="javascript:void(0)" id="printBtn" class="btn-block btn btn-light-indigo waves-effect waves-light invoice-print">
                            <span>{{ __('messages.Print') }}</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn mt-3 mb-3">
                        <a href="javascript:void(0)" id="copyLinkBtn" class="btn-block btn btn-light-amber waves-effect waves-light">
                            <span>{{ __('messages.Copy') }} {{ __('messages.'.$type) }} {{ __('messages.Link') }}</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn mt-3 mb-3">
                        <a href="javascript:void(0)" id="sendByWhatsapp" class="btn-block btn btn-light-purple waves-effect waves-light">
                            <span>{{ __('messages.Send by Whatsapp') }}</span>
                        </a>
                    </div>

                    <div class="invoice-action-btn mt-3 mb-3">
                        <a href="javascript:void(0)" id="sendByMail" class="btn-block btn btn-light-green waves-effect waves-light">
                            <span>{{ __('messages.Send by Mail') }}</span>
                        </a>
                    </div>
                    
                    <div class="divider mt-3 mb-3"></div>
                    <div class="display-flex align-items-center justify-content-between">
                        <span>{{ __('messages.Show') }} {{ __('messages.Materials') }}</span>
                        <div class="switch">
                            <label>
                                <input type="checkbox" id="checkPreMaterials">
                                <span class="lever"></span>
                            </label>
                        </div>
                    </div>
                    <div class="display-flex align-items-center justify-content-between">
                        <span>{{ __('messages.Show') }} {{ __('messages.External Services') }}</span>
                        <div class="switch">
                            <label>
                                <input type="checkbox" id="checkPreServices">
                                <span class="lever"></span>
                            </label>
                        </div>
                    </div>
                    <div class="display-flex align-items-center justify-content-between">
                        <span>{{ __('messages.Show') }} {{ __('messages.Employees') }}</span>
                        <div class="switch">
                            <label>
                                <input type="checkbox" id="checkPreEmployees">
                                <span class="lever"></span>
                            </label>
                        </div>
                    </div>
                    <div class="display-flex align-items-center justify-content-between">
                        <span>{{ __('messages.Show Only Total') }}</span>
                        <div class="switch">
                            <label>
                                <input type="checkbox" id="checkPreTotal">
                                <span class="lever"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <form id="target" action="{{ route('user.clientquotes.index') }}" method="get" style="display:none">
    <input type="submit" value="Go">
</form> -->
<div class="modal fade" id="mailModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalheader">{{ __('messages.Send by Mail') }}</h6>
            </div>
            
            <div class="divider mt-5 mb-5"></div>
            <div class="modal-body">
                <form id="mailForm" name="mailForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="quoteId" class="quoteId">
                    <input type="hidden" name="showMaterial" class="showMaterial">
                    <input type="hidden" name="showService" class="showService">
                    <input type="hidden" name="showEmployee" class="showEmployee">
                    <input type="hidden" name="showOnlyTotal" class="showOnlyTotal">
                    <input type="hidden" name="messageContent" class="messageContent">
                    <div class="input-field" style="margin-top: 1rem;margin-bottom: 1rem;">
                        <i class="material-icons prefix">info_outline</i>
                        <input type="text" class="validate modalInput" name="from" id="from">
                        <label for="from">{{ __('messages.From') }}</label>
                        <div class="error" id="errorfrom">
                        </div>
                    </div>
                    <div class="input-field"  style="margin-top: 1rem;margin-bottom: 1rem;">
                        <i class="material-icons prefix">info_outline</i>
                        <input type="text" class="validate modalInput" name="to" id="to" >
                        <label for="to">{{ __('messages.To') }}</label>
                        <div class="error" id="errorto">
                        </div>
                    </div>
                    <div class="input-field"  style="margin-top: 1rem;margin-bottom: 1rem;">
                        <i class="material-icons prefix">apps</i>
                        <input type="text" class="validate modalInput" name="subject" id="subject" >
                        <label for="subject">{{ __('messages.Subject') }}</label>
                        <div class="error" id="errorsubject">
                        </div>
                    </div>
                    <div class="input-field"  style="margin-top: 1rem;margin-bottom: 1rem;">
                        <i class="material-icons prefix">message</i>
                        <textarea class="materialize-textarea validate modalInput" name="message" id="message" ></textarea>
                        <label for="message">{{ __('messages.Message') }}</label>
                        <div class="error" id="errormessage">
                        </div>
                    </div>
                    <div  class="mt-10 mb-3 user-edit-btns display-flex  justify-content-end ">
                        <button type="submit" class="btn-small indigo" id="sendMailBtn" value="create">{{ __('messages.Send') }}</button>
                        <button class="btn-small btn-light-pink" id="cancelMailBtn" style="margin-left:10px;" value="cancel">{{ __('messages.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="whatsappModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalheader">{{ __('messages.Send by Whatsapp') }}</h6>
            </div>
            
            <div class="divider mt-5 mb-5"></div>
            <div class="modal-body">
                <form id="whatsappForm" name="whatsappForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="quoteId" class="quoteId">
                    <input type="hidden" name="showMaterial" class="showMaterial">
                    <input type="hidden" name="showService" class="showService">
                    <input type="hidden" name="showEmployee" class="showEmployee">
                    <input type="hidden" name="showOnlyTotal" class="showOnlyTotal">
                    <input type="hidden" name="messageContent" class="messageContent">
                    <div class="input-field">
                        <i class="material-icons prefix">phone</i>
                        <input type="text" class="validate modalInput" name="whatsappnumber" id="whatsappnumber" >
                        <label for="whatsappnumber">{{ __('messages.Phone Number') }}</label>
                        <div class="error" id="errorwhatsappnumber">
                        </div>
                    </div>
                    <div class="card-alert card cyan lighten-5">
                        <div class="card-content cyan-text">
                            <p>{{ __('messages.This is the number you want to send to.') }}<br>{{ __('messages.But you can overwrtie if you want to write another number.') }}<br>{{ __('messages.Just validate 10 digits.') }}</p>
                        </div>
                    </div>
                    <div  class="mt-10 mb-3 user-edit-btns display-flex  justify-content-end ">
                        <button type="submit" class="btn-small indigo" id="sendWhatsappBtn" value="create">{{ __('messages.Ok') }}</button>
                        <button class="btn-small btn-light-pink" id="cancelWhatsappBtn" style="margin-left:10px;" value="cancel">{{ __('messages.Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('contentjs')
@include('user.client.cquote.js')
@endsection