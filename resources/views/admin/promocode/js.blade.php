<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('bower_components/admin-lte/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script>
$(document).ready(function () {
    
  $('#quickForm').validate({
    rules: {
      code: {
        required: true,
      },
      discount: {
        required: true,
        number: true,
      },
      name: {
        required: true,
      },
      duration: {
        required: true,
        number: true,
      },
    },
    messages: {
      code: {
        required: "Please provide a code",
      },
      discount: {
        required: "Please provide a discount",
        number: "Discount has to be double value."
      },
      name: {
        required: "Please provide a name",
      },
      duration: {
        required: "Please provide a Duration",
        number: "Duration must be a number",
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
  $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
});
</script>