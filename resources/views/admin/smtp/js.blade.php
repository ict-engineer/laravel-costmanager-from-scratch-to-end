<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script>
$(document).ready(function () {
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
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
      port: {
        required: true,
        number: true,
      },
      server: {
        required: true,
      },
    },
    messages: {
      email: {
        required: "Please provide a email address",
        email: "Please provide a vaild email address"
      },
      password: {
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
      port: {
        required: "Please provide a port",
        number: "Port must be a number",
      },
      server: {
        required: "Please provide a SMTP Server",
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