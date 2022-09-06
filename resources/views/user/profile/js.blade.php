<script src="{{ asset('app-assets/vendors/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-select2.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/page-account-settings.js') }}"></script>
<script src="{{ asset('app-assets/vendors/formatter/jquery.formatter.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-masks.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
<script src="https://unpkg.com/html2canvas@1.0.0-alpha.9/dist/html2canvas.js"></script>

<script src="{{ asset('js/googlemap.js') }}"></script>
<script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqsYlbvunG8q26BV66NAVX3pGEl3lIgdI&libraries=places&callback=initMap">
</script>

<script>
$(".select2").select2({
     /* the following code is used to disable x-scrollbar when click in select input and
     take 100% width in responsive also */
     dropdownAutoWidth: true,
     width: '100%',
});
</script>
<!-- currency -->
<script src="{{ asset('js/phone-prefix.js') }}"></script>

<!-- country -->
<script src="{{ asset('js/country.js') }}"></script>

<script>
    const phoneValue = "{!! $user->countryCode ?? '' !!}";
    if(phoneValue !== '') {
      $('#countrycodeSel').val(phoneValue).change();
    }
    const countryValue1 = "{!! $provider->country ?? '' !!}";
    const countryValue = "{!! $client->country ?? '' !!}";
    if(countryValue !== '') {
      $('#country_selector').val(countryValue).change();
    }
    if(countryValue1 !== '') {
      $('#country_selector1').val(countryValue1).change();
    }
    const numberofemployeesValue = "{!! $client->numberofemployees ?? '' !!}";
    if(numberofemployeesValue !== '') {
      $('#numberofemployees').val(numberofemployeesValue).change();
    }
</script>

<script>

jQuery(document).ready(function($){
    var isEmployee = "{!! (Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales')) ? 'true' : 'false' !!}";

    if(isEmployee == 'true')
    {
        $('#name').prop( "readonly", true);
        $('#phone').prop( "readonly", true);
        $('#countrycodeSel').prop( "readonly", true);
        $('#email').prop( "readonly", true);
        $('#name').removeClass('validate');
        $('#email').removeClass('validate');
        $('#phone').removeClass('validate');
        $('#phone').removeClass('valid');
        $('#saveGeneral').hide();
    }

    $("#saveGeneral").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var data = $('#formGeneral').serialize();
        var type = "POST";
        var ajaxurl = '/user/profile/saveGeneral';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: data,
            dataType: 'json',
            success: function (data) {
                $(".error").html('');
                $('.usernameheader').html(data['name']);
                M.toast({
                    html: data['text'],
                    classes: 'rounded'
                });
            },
            error: function (data) {
                var response = JSON.parse(data.responseText);
                $(".error").html('');
                for (var key in response.errors) {
                    if (response.errors.hasOwnProperty(key)) {
                        $('#error' + key).html(response.errors[key]);
                    }
                }
            }
        });
    });

    $('.copyToken').click(function (e) {
        var dummy = document.createElement('input');
        document.body.appendChild(dummy);
        dummy.value = "{!! $provider->api_token ?? '' !!}";
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        M.toast({
            html: 'Copied to clipboard',
            classes: 'rounded'
        });
    });

    $("#saveProvider").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var data = $('#formProvider').serialize();
        var type = "POST";
        var ajaxurl = '/user/profile/saveProvider';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: data,
            dataType: 'json',
            success: function (data) {
                $(".error").html('');
                // $("#formProvider :input").prop("disabled", true);
                $('#providerText').html('You are registered as a Provider. Change information below.');
                M.toast({
                    html: data['text'],
                    classes: 'rounded'
                });
            },
            error: function (data) {
                var response = JSON.parse(data.responseText);
                $(".error").html('');
                for (var key in response.errors) {
                    if (response.errors.hasOwnProperty(key)) {
                        $('#error' + key + '1').html(response.errors[key]);
                    }
                }
            }
        });
    });
    $("#saveClient").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var data = new FormData(document.getElementById("formClient"));
        var type = "POST";
        var ajaxurl = '/user/profile/saveClient';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: data,
            processData: false,
            contentType: false,
            success: function (data) {
                $(".error").html('');
                // $("#formClient :input").prop("disabled", true);
                $('#clientText').html('You are registered as a Contractor. Change information below.');
                M.toast({
                    html: data['text'],
                    classes: 'rounded'
                });
            },
            error: function (data) {
                var response = JSON.parse(data.responseText);
                $(".error").html('');
                for (var key in response.errors) {
                  
                    if (response.errors.hasOwnProperty(key)) {
                        $('#error' + key + '2').html(response.errors[key]);
                    }
                }
            }
        });
    });
    $("#savePassword").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var data = $('#formPassword').serialize();
        var type = "POST";
        var ajaxurl = '/user/profile/savePassword';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: data,
            dataType: 'json',
            success: function (data) {
                $(".error").html('');
                M.toast({
                    html: data['text'],
                    classes: 'rounded'
                });
            },
            error: function (data) {
                var response = JSON.parse(data.responseText);
                $(".error").html('');
                for (var key in response.errors) {
                    if (response.errors.hasOwnProperty(key)) {
                        $('#error' + key).html(response.errors[key]);
                    }
                }
            }
        });
    });
});
</script>
<script>
updatelist(0);
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
  function updatelist(flag)
  {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    var language = getLanguage();
    console.log(language);
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
          if(flag == 0){
            // const paymentValue =  "{!! $client->payment ?? '' !!}";
            // console.log(paymentValue);
            // if(paymentValue != '') {
            //   $('#payment').val(paymentValue).change();
            // }

            const serviceValue =  {!! json_encode($client['service']) !!};
            if(serviceValue != '') {
              $('#service').val(serviceValue).change();
            }
          }
        },
        error: function (data) {
            console.log(data);
        }
    });
  }
  $('#country_selector').on('change', function() {
    updatelist(1);
  });

    // image upload

    var $modal = $('#ajaxModal');
    var $modalLogo = $('#logoModal');
    var image = document.getElementById('image');
    var logoimage = document.getElementById('logoimage');
    var cropper;
    $("body").on("change", "#userImageDiv", function(e){
        var files = e.target.files;
        var done = function (url) {
            image.src = url;
            $('#ajaxModal').modal('open');
            
        };
        var reader;
        var file;
        var url;
        if (files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $("body").on("change", "#logoImageDiv", function(e){
        var files = e.target.files;
        var done = function (url) {
            sourceLogoImg.src = url;
        };
        var reader;
        var file;
        var url;
        if (files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $('#ajaxModal').modal({
        dismissible: true, // Modal can be dismissed by clicking outside of the modal
        onOpenStart: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
            cropper = new Cropper(image, {
                aspectRatio: 16 / 9,
                dragMode: 'move',
                viewMode: 3,
                aspectRatio: 1,
                preview: '.preview'
            });
            $('#sourceImg').css("display","none");
            $('.preview').css("display","block");
        },
        onCloseEnd: function() {
            cropper.destroy();
            cropper = null;
            $('#sourceImg').css("display","block");
            $('.preview').css("display","none");
        } // Callback for Modal close
    });

    // $('#logoModal').modal({
    //     dismissible: true, // Modal can be dismissed by clicking outside of the modal
    //     onOpenStart: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
    //         $('#sourceLogoImg').css("display","none");
    //         $('.logopreview').css("display","block");
    //     },
    //     onCloseEnd: function() {
    //         $('#sourceLogoImg').css("display","block");
    //         $('.logopreview').css("display","none");
    //     } // Callback for Modal close
    // });

    $('#cancelBtn').on('click', function() {
        $('#ajaxModal').modal('close');
        $('#upfile').val('');
    })

    $('#cancelLogoBtn').on('click', function() {
        $('#logoModal').modal('close');
        $('#upfileLogo').val('');
    })

    $('#showMap').on('click', function(e) {
        e.preventDefault();
        if($('#map').css('display') == "none")
        {
            $('#map').show();
            $(this).text("Hide Map");
        }
        else
        {
            $('#map').hide();
            $(this).text("Show Map");
        }
    })

    $("#saveBtn").click(function(){
        canvas = cropper.getCroppedCanvas({
            width: 150,
            height: 150,
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob); 
            reader.onloadend = function() {
                var base64data = reader.result; 
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('crop-image-upload') }}",
                    data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                    success: function(data){
                        $('#upfile').val('');
                        $modal.modal('close');
                        $('#sourceImg').attr("src", data['img']);
                        $('#userAvatar').attr("src", data['img']);
                    }
                });
            }
        });
    })
    
    // $("#saveLogoBtn").click(function(){
    //     html2canvas(logoimage).then(function(canvas) {
    //         canvas.toBlob(function(blob) {
    //             url = URL.createObjectURL(blob);
    //             var reader = new FileReader();
    //             reader.readAsDataURL(blob); 
    //             reader.onloadend = function() {
    //                 var base64data = reader.result; 
    //                 $.ajax({
    //                     type: "POST",
    //                     dataType: "json",
    //                     url: "{{ route('crop-logo-image-upload') }}",
    //                     data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
    //                     success: function(data){
    //                         $('#upfileLogo').val('');
    //                         $modalLogo.modal('close');
    //                         $('#sourceLogoImg').attr("src", data['img']);
    //                     }
    //                 });
    //             }
    //         });
    //     });
        
    // })
</script>

