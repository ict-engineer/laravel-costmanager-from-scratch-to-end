@extends('layouts.setlayout')

@section('contentcss')
@endsection

@section('content')
<div class="wrap-set pt-3 pb-3 pl-2 pr-2">
    <h4 style="font-family: Poppins-Bold;font-weight: bold;font-size: 30px;text-align:center;">
        {{ __('messages.Set Provider Info') }}
    </h4>
    <form role="form" id="quickForm" action="{{ route('user.setProviderInfo') }}" method="POST">
        @csrf
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">groups</i>
                <input type="text"  class="validate" name="companyname" id="providercompany"  value="{{ old('companyname') ?? '' }}"  >
                <label for="providercompany">{{ __('messages.Company Name') }}</label>
                @if( $errors->has( 'companyname' ) )
                    <div class="error" id="errorcompanyname1">
                        {{ $errors->first( 'companyname' ) }} 
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">location_city</i>
                <input type="text"  class="validate" name="addline1" id="provideraddline1" value="{{ old('addline1') ?? '' }}" >
                <label for="provideraddline1">{{ __('messages.Address Line') }}</label>
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
                <input type="text"  class="validate" name="cp" id="providercp1" value="{{ old('cp') ?? '' }}" >
                <label for="providercp1">C.P.</label>
            </div>        
        </div>           
        <div class="row">
            <div class="input-field col s12">
                <button class="btn waves-effect waves-light center set-btn" type="submit" id="saveProvider">{{ __('messages.Save') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('contentjs')
<script src="{{ asset('app-assets/vendors/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-select2.js') }}"></script>

<!-- country -->
<script src="{{ asset('js/country.js') }}"></script>

<script>
    const countryOldValue = "{!! old( 'country') !!}";
    if(countryOldValue !== '') {
        $('#country_selector').val(countryOldValue).change();
    }
    $('#quickForm').validate({
        rules: {
            companyname: {
                required: true,
            },
            addline1: {
                required: true,
            },
            cp: {
                required: true,
            },
        },
        messages: {
            companyname: {
                required: "Please enter a name",
            },
            addline1: {
                required: "Please enter a address line1",
            },
            cp: {
                required: "Please enter a C.P.",
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });
</script>
@endsection
