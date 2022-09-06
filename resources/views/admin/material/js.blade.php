<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script>
$(document).ready(function () {
  // validate
  $('#quickForm').validate({
    rules: {
      description: {
        required: true,
      },
      price: {
        required: true,
        number: true,
      },
      sku: {
        number: true,
      },
      shoplist: {
        required: true,
      },
    },
    messages: {
      description: {
        required: "Please input a material description.",
      },
      price: {
        required: "Please input a material price.",
        number: "Only input number."
      },
      sku: {
        number: "Only input number."
      },
      shoplist: {
        required: "Please input a shop name.",
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
<script>
$(document).on('click', '.myCheckbox', function () {
  var target = $(this).data('target');    
  if ($(this).is(':checked'))  
  {
      // document.getElementById("imagedes").style.display = "block";
      // document.getElementById("kt_image_1").style.display = "block";
      document.getElementById("image").disabled = false;
      document.getElementById("exampleInputImage1").disabled = true;
  }
  else
  {
      // document.getElementById("imagedes").style.display = "none";
      // document.getElementById("kt_image_1").style.display = "none";
      document.getElementById("exampleInputImage1").disabled = false;
      document.getElementById("image").disabled = true;
  }
});
</script>
<!--- file upload --->

<!-- <script src="{{ asset('js/image-input.js') }}"></script> -->
<script src="{{ asset('bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
  $('.select2').select2();
  var providers = {!! $providers !!};
  var provider;
  for(provider of providers)
    $('#providerlist').append(new Option(provider, provider));
  
  const providerValue = "{!! $material->providerlist ?? '' !!}";
  if(providerValue !== '') {
    $('#providerlist').val(providerValue);
  }
  const providerOldValue = "{!! old( 'providerlist') !!}";
  if(providerOldValue !== '') {
    $('#providerlist').val(providerOldValue);
  }

  updateshoplist(0);

  
  function updateshoplist(flag)
  {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'GET',
        url: "{{URL::to('shoplist')}}",
        data: {email:$('#providerlist').val()},
        dataType: 'json',
        success: function (data) {
          var shop;
          $('#shoplist').empty();
          for(shop of data)
            $('#shoplist').append(new Option(shop, shop));
          if(flag == 0)
          {
            const shopValue = "{!! $material->shoplist ?? '' !!}";
            if(shopValue !== '') {
              $('#shoplist').val(shopValue);
            }
            const shopOldValue = "{!! old( 'shoplist') !!}";
            if(shopOldValue !== '') {
              $('#shoplist').val(shopOldValue);
            }
          }
        },
        error: function (data) {
            console.log(data);
        }
    });
  }
  $('#providerlist').on('change', function() {
    updateshoplist(1);
  });
</script>