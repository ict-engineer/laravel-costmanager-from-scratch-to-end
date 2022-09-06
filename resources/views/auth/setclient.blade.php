@extends('layouts.setlayout')

@section('contentcss')
@endsection

@section('content')
<div class="wrap-set pt-3 pb-3 pl-2 pr-2">
    <h4 style="font-family: Poppins-Bold;font-weight: bold;font-size: 30px;text-align:center;">
        {{ __('messages.Set Your Company Info') }}
    </h4>
    <form role="form" id="quickForm" action="{{ route('user.setClientInfo') }}" method="POST">
        @csrf
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">groups</i>
                <input type="text" class="validate" name="companyname" id="exampleInputCompany1" value="{{ old('companyname') ?? '' }}" >
                <label for="exampleInputCompany1">{{ __('messages.Company Name') }}</label>
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
                <input type="text" class="validate" name="addline1" id="exampleInputAddline1" value="{{ old('addline1') ?? '' }}" >
                <label for="exampleInputAddline1">{{ __('messages.Address Line') }}</label>
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
                <input type="text" class="validate" name="cp" id="exampleInputCp1" value="{{ old('cp') ?? '' }}" >
                <label for="exampleInputCp1">C.P.</label>
            </div>                   
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">business</i>
                <div style="margin-left: 3rem">
                <select name="numberofemployees"  class="select2 browser-default" id="numberofemployees" style="width:100%;"  value="{{ old('numberofemployees') ?? '' }}" >
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
            </div>           
        </div> -->
        <div class="row">
            <div class="input-field col s12">
                <button class="btn waves-effect waves-light center set-btn" type="submit" id="saveclient">{{ __('messages.Save') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('contentjs')
<script src="{{ asset('app-assets/vendors/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-select2.js') }}"></script>

<script>
    $(".select2").select2({
        /* the following code is used to disable x-scrollbar when click in select input and
        take 100% width in responsive also */
        dropdownAutoWidth: true,
        width: '100%',
    });
</script>

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
            service: {
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
            service: {
                required: "Please enter a service",
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

<script>
updatelist();
  function getLanguage()
  {
    var country = $('#country_selector').val();
    if(country == "Spain" || country == "Mexico")
      return 1;
    if(country == "France")
      return 2;
    if(country == "Italy")
      return 3;
    if(country == "Russia")
      return 4;
    if(country == "Germany")
      return 5;

    return 0;
  }
  function updatelist()
  {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    var language = getLanguage();
    $.ajax({
        type: 'GET',
        url: "{{URL::to('servicepaymentlist')}}",
        data: {language:language, country:$('#country_selector').val()},
        dataType: 'json',
        success: function (data) {
          var ele;
          $('#service').empty();
        //   $('#payment').empty();
          for(ele of data['services'])
            $('#service').append(new Option(ele, ele));
        //   for(ele of data['payments'])
        //     $('#payment').append(new Option(ele, ele));

        //     const paymentValue =  "{!! old('payment') ?? '' !!}";
        //     console.log(paymentValue);
        //     if(paymentValue != '') {
        //       $('#payment').val(paymentValue).change();
        //     }

            const serviceValue =  {!! json_encode(old('service')) !!};
            if(serviceValue != '') {
              $('#service').val(serviceValue).change();
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
  }
  $('#country_selector').on('change', function() {
    updatelist();
  });
 </script>

@endsection
