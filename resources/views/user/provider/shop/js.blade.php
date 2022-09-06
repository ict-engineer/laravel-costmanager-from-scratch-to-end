<!-- jquery-validation -->
<script src="{{ asset('app-assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>

<script src="{{ asset('js/googlemap.js') }}"></script>
<script defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqsYlbvunG8q26BV66NAVX3pGEl3lIgdI&libraries=places&callback=initMap">
</script>

<!-- select -->
<script src="{{ asset('app-assets/vendors/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-select2.js') }}"></script>
<!-- currency -->
<script src="{{ asset('js/currency.js') }}"></script>

<!-- country -->
<script src="{{ asset('js/country.js') }}"></script>

<script>

$(document).ready(function () {
  const currencyValue = "{!! $shop->currency ?? '' !!}";
  if(currencyValue !== '') {
    $('#currency').val(currencyValue).change();
  }
  const currencyOldValue = "{!! old( 'currency') !!}";
  if(currencyOldValue !== '') {
    $('#currency').val(currencyOldValue).change();
  }
  $('#quickForm').validate({
    rules: {
      name: {
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
      name: {
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
});
</script>

<script>
  const countryValue = "{!! $shop->country ?? '' !!}";
  if(countryValue !== '') {
    $('#country_selector').val(countryValue).change();
  }
  const countryOldValue = "{!! old( 'country') !!}";
  if(countryOldValue !== '') {
    $('#country_selector').val(countryOldValue).change();
  }
</script>
