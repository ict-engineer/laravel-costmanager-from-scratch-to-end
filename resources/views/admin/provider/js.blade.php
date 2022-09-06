<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<!-- select -->
<script src="{{ asset('bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- phone prefix -->
<script src="{{ asset('js/phone-prefix.js') }}"></script>
<!-- country -->
<script src="{{ asset('js/country.js') }}"></script>

<!-- InputMask -->
<script src="{{ asset('bower_components/admin-lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>




<script>
 $(document).on('click', '#resetcheck', function () {
  var target = $(this).data('target');    
  if ($(this).is(':checked'))  
  {
      document.getElementById("exampleInputPassword3").disabled = false;
      document.getElementById("exampleInputPassword2").disabled = false;
  }
  else
  {
      document.getElementById("exampleInputPassword3").disabled = true;
      document.getElementById("exampleInputPassword2").disabled = true;
  }
});
$(document).ready(function () {
  const phoneValue = "{!! $provider->countryCode ?? '' !!}";
  if(phoneValue !== '') {
    $('#countrycodeSel').val(phoneValue).change();
  }
  const phoneOldValue = "{!! old( 'countryCode') !!}";
  if(phoneOldValue !== '') {
    $('#countrycodeSel').val(phoneOldValue).change();
  }
  const countryValue = "{!! $provider->country ?? '' !!}";
  if(countryValue !== '') {
    $('#country_selector').val(countryValue).change();
  }
  const countryOldValue = "{!! old( 'country') !!}";
  if(countryOldValue !== '') {
    $('#country_selector').val(countryOldValue).change();
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
      addline2: {
        required: true,
      },
      cp: {
        required: true,
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
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
        required: "Please enter a name",
      },
      companyname: {
        required: "Please enter a companyname",
      },
      addline1: {
        required: "Please enter a address line1",
      },
      addline2: {
        required: "Please enter a address line2",
      },
      cp: {
        required: "Please enter a C.P.",
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
