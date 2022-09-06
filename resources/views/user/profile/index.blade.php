@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/page-account-settings.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('app-assets/vendors/select2/select2-materialize.css') }}" type="text/css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>

<style>
    .token_body {
        display: table;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .token_row {
        display: table-row;
        box-shadow: rgb(224 224 224) 0px -1px 0px 0px inset;
        box-sizing: border-box;
    }

    .token_header {
        width: 5rem;
        color: rgb(0, 0, 0);
        font-size: 1.1rem;
        display: table-cell;
        padding: 8px 0px;
        padding-left: 5px;
        vertical-align: top;
        box-sizing: border-box;
    }

    .token_content {
        display: table-cell;
        font-size: 1.1rem;
        margin-bottom: 0px;
        padding-bottom: 8px;
        padding-top: 8px;
        color: rgba(0, 0, 0, 0.66);
        padding-left: 24px;
        word-break: break-word;
        min-width: 64px;
        vertical-align: top;
        box-sizing: border-box;
    }
</style>
<style>
  #ajaxModal {
    max-width: 300px;
    overflow: hidden;
  }

  #logoModal {
    max-width: 300px;
    overflow: hidden;
  }
    /* Set the size of the div element that contains the map */
  #map {
    height: 400px;  /* The height is 400 pixels */
    width: 100%;  /* The width is the width of the web page */
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
 
</style>
@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.User Settings') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.User Settings') }}
    </li>
</ol>
@endsection
@section('content')

<div class="tabs-vertical mt-1 section">
  <div class="row">
      <div class="col l4 s12">
        <!-- tabs  -->
        <div class="card-panel">
          <div class="display-flex justify-content-center">
            <div class="image-div">
              @if($user->image == '')
                <img src="{{ asset('imgs/user.png') }}" width="150" height="150" id="sourceImg"></img>
              @else
                <img src="{{ url($user->image) }}" width="150" height="150" id="sourceImg"></img>
              @endif
              <div class="preview"></div>
              <button class="btn-floating waves-effect waves-light newimage-btn" id="select-files"><i class="material-icons">add_a_photo</i></button>
              <div class="upfilewrapper" style="display:none;"  id="userImageDiv">
                    <input id="upfile" type="file"  accept=".png,.jpeg,.jpg" data-default-file="" data-allowed-file-extensions='["png", "jpg", "jpeg"]'/>
                </div>
            </div>
          </div>
          
          <ul class="tabs mt-3">
              <li class="tab">
                  <a href="#General">
                      <i class="material-icons">brightness_low</i>
                      <span>{{ __('messages.User Information') }}</span>
                  </a>
              </li>
              <li class="tab">
                  <a href="#password">
                      <i class="material-icons">lock_open</i>
                      <span>{{ __('messages.Security') }}</span>
                  </a>
              </li>
              @if(Session::get('type') == 'Provider')
              <li class="tab">
                  <a href="#Provider">
                      <i class="material-icons">error_outline</i>
                      <span>{{ __('messages.Company Info') }}</span>
                  </a>
              </li>
              <li class="tab">
                  <a href="#token">
                      <i class="material-icons">vpn_key</i>
                      <span>API</span>
                  </a>
              </li>
              @endif
              @if(Session::get('type') == 'Client' && !(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales')))
              <li class="tab">
                  <a href="#Client">
                      <i class="material-icons">chat_bubble_outline</i>
                      <span>{{ __('messages.Company Info') }}</span>
                  </a>
              </li>
              @endif
          </ul>
      </div>
      </div>
      <div class="col l8 s12">
      <div id="General" class="card-panel tabcontent scrollspy">
          <div class="card-content">
            <div class="card-alert card cyan lighten-5">
                <div class="card-content cyan-text">
                    <p id="providerText">{{ __('messages.Change general information below.') }}</p>
                </div>
            </div>
            <form role="form" id="formGeneral">
                  @csrf
                <div class="row">
                  <div class="input-field col s12">
                      <i class="material-icons prefix">account_circle</i>
                      <input type="text"  class="validate" name="name" id="name"  value="{{ $user->name ?? '' }}"  >
                      <label for="name">{{ __('messages.Name') }}</label>
                      <div class="error" id="errorname">
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                      <i class="material-icons prefix">email</i>
                      <input type="text"  class="validate" name="email" id="email"  value="{{ $user->email ?? '' }}"  >
                      <label for="email">{{ __('messages.E-Mail Address') }}</label>
                      <div class="error" id="erroremail">
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                      <i class="material-icons prefix">phone</i>
                      <div style="display:flex;margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">
                          <select name="countryCode" id="countrycodeSel" style="width:100px;" class="select2 browser-default">
                            @include('user.components.phoneprefix')
                          </select>
                            <label style="margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);" for="countrycodeSel">{{ __('messages.Phone Number') }}</label>
                            <input type="text"  class="validate" name="phone" id="phone"  data-inputmask='"mask": "(999) 999-9999"' value="{{ $user->phone }}" >
                      </div>
                      <div class="error" id="errorphone">
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                    <button class="btn cyan waves-effect waves-light right" type="submit" id="saveGeneral" name="action">{{ __('messages.Save') }}
                      <i class="material-icons right">send</i>
                    </button>
                  </div>
                </div>        
            </form>
          </div>
        </div>
        @if(Session::get('type') == 'Provider')
        <div id="Provider" class="card-panel tabcontent scrollspy">
          <div class="card-content">
            <div class="card-alert card cyan lighten-5">
                <div class="card-content cyan-text">
                  @role('Provider')
                    <p id="providerText">{{ __('messages.You are registered as a Provider. Change information below.') }}</p>
                  @else
                    <p id="providerText">{{ __('messages.Please provide information to register as a Provider.') }}</p>
                  @endrole
                </div>
            </div>
            <form role="form" id="formProvider">
                  @csrf
                <div class="row">
                  <div class="input-field col s12">
                      <i class="material-icons prefix">groups</i>
                      <input type="text"  class="validate" name="companyname" id="providercompany"  value="{{ $provider->companyname ?? '' }}"  >
                      <label for="providercompany">{{ __('messages.Company Name') }}</label>
                      <div class="error" id="errorcompanyname1">
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                      <i class="material-icons prefix">location_city</i>
                      <input type="text"  class="validate" name="addline1" id="provideraddline1" value="{{ $provider->addline1 ?? '' }}" >
                      <label for="provideraddline1">{{ __('messages.Address Line') }}</label>
                      <div class="error" id="erroraddline11">
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                      <i class="material-icons prefix">location_on</i>
                      <div style="margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">
                        <select name="country" id="country_selector1" style="width:100%;" class="select2 browser-default">
                          @include('user.components.country')
                        </select>
                        <label for="country_selector1" style="margin-left: 3rem;width: calc(100% - 3rem);width: calc(100% - 3rem);">{{ __('messages.Country') }}</label>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                      <i class="material-icons prefix">code</i>
                      <input type="text"  class="validate" name="cp" id="providercp1" value="{{ $provider->cp ?? '' }}" >
                      <label for="providercp1">C.P.</label>
                        <div class="error" id="errorcp1">
                        </div>
                  </div>        
                </div>           
                <div class="row">
                  <div class="input-field col s12">
                    <button class="btn cyan waves-effect waves-light right" type="submit" id="saveProvider" name="action">{{ __('messages.Save') }}
                      <i class="material-icons right">send</i>
                    </button>
                  </div>
                </div>
            </form>
        </div>
      </div>
      <div id="token" class="card-panel tabcontent scrollspy">
            <div class="card-content">
                <div class="card-alert card cyan lighten-5">
                    <div class="card-content cyan-text">
                        <p id="providerText">{{ __('messages.You can check your API key. Using api you can create, edit, delete shops and materials.') }}</p>
                    </div>
                </div>
            </div>
            <div style="display:flex; justify-content: center;">
                <div class="token_body">
                    <div class="token_row">
                        <div class="token_header">{{ __('messages.Key') }}</div>
                        <div class="token_content">{{ $provider->api_token }}</div>
                        <div style="display:table-cell; padding-left:4px; padding-top: 9px;"><i data-position="bottom" data-tooltip="{{ __('messages.Copy') }}" class="material-icons copyToken tooltipped" style="cursor:pointer;">content_copy</i></div>
                        
                    </div>
                    <div class="token_row">
                        <div class="token_header">{{ __('messages.Created') }}</div>
                        <div class="token_content">{{ $provider->created_at->format('M d, Y H:i:s') }}</div>
                    </div>
                    <div class="token_row">
                        <div class="token_header">{{ __('messages.Help') }}</div>
                        <div class="token_content"><a href="/api_docs" target="_blank">https://www.thequotebox.app/api_docs</a></div>
                    </div>
                </div>
            </div>
      </div>
      @endif
      @if(Session::get('type') == 'Client' && !(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales')))
      <div id="Client" class="card-panel tabcontent scrollspy" style="display:none;">
        <div class="card-content">
          <div class="card-alert card cyan lighten-5">
                <div class="card-content cyan-text">
                  @role('Client')
                    <p id="clientText">{{ __('messages.You are registered as a Contractor. Change information below.') }}</p>
                  @else
                    <p id="clientText">{{ __('messages.Please provide information to register as a Contractor.') }}</p>
                  @endrole
                </div>
            </div>
          <form role="form" id="formClient">
            @csrf
            <input type="hidden" name="lat" id="lat" value="{{ old( 'lat', $client->lat) }}">
            <input type="hidden" name="lng" id="lng" value="{{ old( 'lng', $client->lng) }}">
            <div class="row">
                <div class="input-field col s12">
                <div class="display-flex justify-content-center">
                    <div class="image-div" style="width:auto;height:auto;">
                    @if($user->logoimage == '' && $user->logoimage == null)
                        <img src="{{ asset('imgs/logo1.png') }}" width="150"  id="sourceLogoImg"></img>
                    @else
                        <img src="{{ url($user->logoimage) }}" id="sourceLogoImg" width="150" ></img>
                    @endif
                    <!-- <div class="logopreview"></div> -->
                        <button class="btn-floating waves-effect waves-light newimage-btn" id="select-logo-files"><i class="material-icons">add_a_photo</i></button>
                        <div class="upfilewrapper" style="display:none;" id="logoImageDiv">
                            <input id="upfileLogo" type="file" name="image"  accept=".png,.jpeg,.jpg" data-default-file="" data-allowed-file-extensions='["png", "jpg", "jpeg"]'/>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                  <i class="material-icons prefix">groups</i>
                  <input type="text" class="validate" name="companyname" id="exampleInputCompany1" value="{{ $client->companyname ?? '' }}" >
                  <label for="exampleInputCompany1">{{ __('messages.Company Name') }}</label>
                  <div class="error" id="errorcompanyname2">
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                  <i class="material-icons prefix">location_city</i>
                  <input type="text" class="validate" name="addline1" id="addline1" value="{{ $client->addline1 ?? '' }}" >
                  <label for="addline1">{{ __('messages.Address Line') }}</label>
                  <div class="error" id="erroraddline12">
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                  <i class="material-icons prefix">location_on</i>
                  
                  <div style="margin-left: 3rem;width: calc(100% - 3rem);">
                    <select name="country" id="country_selector" style="width:100%;" class="select2 browser-default">
                        @include('user.components.country')
                    </select>
                    <label for="country_selector" style="margin-left:3rem;width: calc(100% - 3rem);">{{ __('messages.Country') }}</label>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                  <i class="material-icons prefix">code</i>
                  <input type="text" class="validate" name="cp" id="exampleInputCp1" value="{{ $client->cp ?? '' }}" >
                  <label for="exampleInputCp1">C.P.</label>
                  <div class="error" id="errorcp2">
                  </div>
              </div>                   
            </div>
            <div class="row">
              <div class="input-field col s12">
                  <i class="material-icons prefix">business</i>
                  <div style="margin-left: 3rem">
                    <select name="numberofemployees"  class="select2 browser-default" id="numberofemployees" style="width:100%;"  value="{{ $client->numberofemployees ?? '' }}" >
                        <option value="1-5">1-5</option>
                        <option value="6-20">6-20</option>
                        <option value="21-50">21-50</option>
                        <option value="More than 50">More than 50</option>
                    </select>
                    <label style="margin-left:3rem" for="numberofemployees">{{ __('messages.Number of Employees') }}</label>
                  </div>
              </div>         
            </div>
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">face</i>
                  <div style="margin-left: 3rem">
                    <select name="service[]" class="select2 browser-default" multiple="multiple" id="service" style="width:100%;">        </select>
                    <label style="margin-left:3rem" for="service">{{ __('messages.Select what most describe your businesses:') }}</label>
                    </div>
                    <div class="error" id="errorservice2">
                  </div>
              </div>         
            </div>
            <!-- <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">payment</i>
                <div style="margin-left:3rem">
                  <select name="payment" class="select2 browser-default" id="payment" style="width:100%;">
                  </select>
                  <label style="margin-left:3rem" for="payment">Select the plan what is best for you:</label>
                </div>
                  <div class="error" id="errorpayment2">
                  </div>
              </div>           
            </div> -->
            <div id="map" style="display:none;"></div>
            <div class="row">
              <div class="input-field col s12">
                <button class="btn cyan waves-effect waves-light right" style="padding: 0 1.5rem;" type="submit" id="saveClient" name="action">{{ __('messages.Save') }}
                  <i class="material-icons right">send</i>
                </button>
                <button class="btn indigo waves-effect waves-light right" style="margin-right:1%;padding: 0 1.5rem;" id="showMap" name="action">{{ __('messages.Show Map') }}</button>
              </div>
            </div>        
          </form>
        </div>
      </div>
      @endif
      <div id="password" class="card-panel tabcontent scrollspy" style="display:none;">
        <div class="card-content">
            <div class="card-alert card cyan lighten-5">
                <div class="card-content cyan-text">
                    <p>{{ __('messages.Change Password.') }}</p>
                </div>
            </div>
            <form role="form" id="formPassword">
            @csrf
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">lock_outline</i>
                    <input type="password" class="validate" name="password" id="currentPassword">
                    <label for="currentPassword">{{ __('messages.Current Password') }}</label>
                    <div class="error" id="errorpassword">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">lock_outline</i>
                    <input type="password" class="validate" name="newPassword" id="newPassword">
                    <label for="newPassword">{{ __('messages.New Password') }}</label>
                    <div class="error" id="errornewPassword">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">lock_outline</i>
                    <input type="password" class="validate" name="confirmPassword" id="confirmPassword">
                    <label for="confirmPassword">{{ __('messages.Confirm Password') }}</label>
                    <div class="error" id="errorconfirmPassword">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <button class="btn cyan waves-effect waves-light right" type="submit" id="savePassword" name="action">{{ __('messages.Save') }}
                    <i class="material-icons right">send</i>
                  </button>
                </div>
              </div>        
            </form>
            
        </div>
      </div>
    </div>
  </div>
</div>
    
<div class="modal" id="ajaxModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalheader">{{ __('messages.Upload') }} {{ __('messages.Image') }}</h6>
            </div>
            
            <div class="divider mt-1 mb-1"></div>
            <div class="modal-body">
              <div class="imageout-bg">
                <img id="image" style="width:100%;" src="https://avatars0.githubusercontent.com/u/3456749">
              </div>
              
              <div class="divider mb-3"></div>
              <div  class="mb-3 user-edit-btns display-flex  justify-content-end ">
                  <button type="submit" class="btn-small indigo" id="saveBtn" value="create">{{ __('messages.Upload') }}</button>
                  <button class="btn-small btn-light-pink" id="cancelBtn" style="margin-left:10px;" value="cancel">{{ __('messages.Cancel') }}</button>
              </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal" id="logoModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modalheader">Upload Logo</h6>
            </div>
            
            <div class="divider mt-1 mb-1"></div>
            <div class="modal-body">
              <div class="imageout-bg">
                <img id="logoimage" style="width:100%;" src="https://avatars0.githubusercontent.com/u/3456749">
              </div>
              
              <div class="divider mb-3"></div>
              <div  class="mb-3 user-edit-btns display-flex  justify-content-end ">
                  <button type="submit" class="btn-small indigo" id="saveLogoBtn" value="create">Upload</button>
                  <button class="btn-small btn-light-pink" id="cancelLogoBtn" style="margin-left:10px;" value="cancel">Cancel</button>
              </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
@section('contentjs')
  @include('user.profile.js')
@endsection