
<!-- select -->
<script src="{{ asset('bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- currency -->
<script src="{{ asset('js/currency.js') }}"></script>
<!-- language -->
<script src="{{ asset('js/country.js') }}"></script>

<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('bower_components/admin-lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote();
  })
</script>

<script>
$(document).ready(function () {
  const countryValue = "{!! $payment->country ?? '' !!}";
  if(countryValue !== '') {
    $('#country_selector').val(countryValue).change();
  }
  const countryOldValue = "{!! old( 'country') !!}";
  if(countryOldValue !== '') {
    $('#country_selector').val(countryOldValue).change();
  }
  const descriptionValue = '{!! $payment->description ?? '' !!}';
  if(descriptionValue !== '') {
    $('.note-editable p').html( descriptionValue );
    $('#description').html( descriptionValue );
  }
  const currencyValue = "{!! $payment->currency ?? '' !!}";
  if(currencyValue !== '') {
    $('#currency').val(currencyValue).change();
  }
  const descriptionOldValue = '{!! old( 'description') !!}';
  if(descriptionOldValue !== '') {
    $('.note-editable p').html( descriptionOldValue );
    $('#description').html( descriptionOldValue );
  }
  const currencyOldValue = "{!! old( 'currency') !!}";

  if(currencyOldValue !== '') {
    $('#currency').val(currencyOldValue).change();
  }
  // validate
  $('#quickForm').validate({
    rules: {
      name: {
        required: true,
      },
      description: {
        required: true,
      },
      numberofusers: {
        required: true,
        number: true,
      },
      price: {
        required: true,
        number: true,
      },
    },
    messages: {
      name: {
        required: "Please enter a name",
      },
      description: {
        required: "Please enter a description",
      },
      numberofusers: {
        required: "Please enter a number of users",
        number: "Input only number",
      },
      price: {
        required: "Please enter a price",
        number: "Input only number",
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.col-sm-8').append(error);
      element.closest('.paymentdescription').append(error);
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
