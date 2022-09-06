<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script src="{{ asset('js/googlemap.js') }}"></script>
<script defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqsYlbvunG8q26BV66NAVX3pGEl3lIgdI&libraries=places&callback=initMap">
</script>

<!-- select -->
<script src="{{ asset('bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
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
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.col-sm-8').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
<!--- delete shop ---->
<script type="text/javascript">
  $("body").on("click",".remove-shop",function(){
    var current_object = $(this);
    swal({
        title: "{{ __('messages.Are you sure?') }}",
        text: "{{ __('messages.You will not be able to recover this info!') }}",
        type: "error",
        showCancelButton: true,
        dangerMode: true,
        cancelButtonClass: '#DD6B55',
        confirmButtonColor: '#dc3545',
        confirmButtonText: "{{ __('messages.Delete') }}" + '!',
        cancelButtonText: "{{ __('messages.Cancel') }}",
    },function (result) {
        if (result) {
            var action = current_object.attr('data-action');
            var token = jQuery('meta[name="csrf-token"]').attr('content');
            var id = current_object.attr('data-id');

            $('body').html("<form class='form-inline remove-form' method='post' action='"+action+"'></form>");
            $('body').find('.remove-form').append('<input name="_method" type="hidden" value="delete">');
            $('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
            $('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
            $('body').find('.remove-form').submit();
        }
    });
});
</script>
<!-- InputMask -->
<script src="{{ asset('bower_components/admin-lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>


<script>
  $('#providerlist').select2();
  const countryValue = "{!! $shop->country ?? '' !!}";
  if(countryValue !== '') {
    $('#country_selector').val(countryValue).change();
  }
  const countryOldValue = "{!! old( 'country') !!}";
  if(countryOldValue !== '') {
    $('#country_selector').val(countryOldValue).change();
  }
  var providers = {!! $providers !!};
  var provider;
  for(provider of providers)
    $('#providerlist').append(new Option(provider, provider));
  
  const providerValue = "{!! $shop->provider->companyname ?? '' !!}";
  if(providerValue !== '') {
    $('#providerlist').val(providerValue);
  }
  const providerOldValue = "{!! old( 'providerlist') !!}";
  if(providerOldValue !== '') {
    $('#providerlist').val(providerOldValue);
  }
</script>
