<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<!-- select -->
<script src="{{ asset('bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- phone prefix -->
<script src="{{ asset('js/phone-prefix.js') }}"></script>
<!-- country -->
<script src="{{ asset('js/country.js') }}"></script>

<script>
  $('#numberofemployees').select2();
  $('#service').select2();
  $('#payment').select2();
</script>
<!-- InputMask -->
<script src="{{ asset('bower_components/admin-lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>


<script>
$(document).ready(function () {
  const phoneValue = "{!! $client->countryCode ?? '' !!}";
  if(phoneValue !== '') {
    $('#countrycodeSel').val(phoneValue).change();
  }
  const phoneOldValue = "{!! old( 'countryCode') !!}";
  if(phoneOldValue !== '') {
    $('#countrycodeSel').val(phoneOldValue).change();
  }
  const countryValue = "{!! $client->country ?? '' !!}";
  if(countryValue !== '') {
    $('#country_selector').val(countryValue).change();
  }
  const countryOldValue = "{!! old( 'country') !!}";
  if(countryOldValue !== '') {
    $('#country_selector').val(countryOldValue).change();
  }
  const numberofemployeesValue = "{!! $client->numberofemployees ?? '' !!}";
  if(numberofemployeesValue !== '') {
    $('#numberofemployees').val(numberofemployeesValue).change();
  }
  const numberofemployeesOldValue = "{!! old( 'numberofemployees') !!}";
  if(numberofemployeesOldValue !== '') {
    $('#numberofemployees').val(numberofemployeesOldValue).change();
  }
 
  $('[data-mask]').inputmask()
  // validate
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      new_password: {
        required: true,
        minlength: 8
      },
      confirm_password: {
        required: true,
        minlength: 8
      },
      name: {
        required: true,
      },
      phone: {
        required: true,
        minlength: 10,
      },
      companyname: {
        required: true,
      },
      addline1: {
        required: true,
      },
      cp: {
        required: true,
      },
      numberofemployees: {
        required: true,
      },
      service: {
        required: true,
      },
      payment: {
        required: true,
      },
    },
    messages: {
      email: {
        required: "Please provide a email address",
        email: "Please provide a vaild email address"
      },
      new_password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 8 characters long"
      },
      confirm_password: {
        required: "Please provide a confirm_password",
        minlength: "Your password must be at least 8 characters long"
      },
      name: {
        required: "Please provide a name",
      },
      companyname: {
        required: "Please provide a companyname",
      },
      addline1: {
        required: "Please provide a address line1",
      },
      cp: {
        required: "Please provide a C.P.",
      },
      numberofemployees: {
        required: "Please provide a number of employees.",
      },
      service: {
        required: "Please provide a service.",
      },
      payment: {
        required: "Please provide a payment.",
      },
      phone: {
        required: "Please provide a phone number",
        minlength: "Your phone number must be at least 10 characters long",
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