<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>

<!-- jquery-validation -->
<script src="{{ asset('app-assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>

<!-- END PAGE VENDOR JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="{{ asset('app-assets/js/scripts/data-tables.js') }}"></script>
<!-- END PAGE LEVEL JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<!-- file upload -->
<script src="{{ asset('custom_components/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('custom_components/dropify/form-file-uploads.min.js') }}"></script>

<!-- select -->
<script src="{{ asset('app-assets/vendors/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-select2.js') }}"></script>

<script src="{{ asset('app-assets/vendors/quill/quill.min.js') }}"></script>

<script>
    var shops = {!! $shops !!};
    var shop;
    $('#shoplist').append(new Option('All', 'All'));
    for(shop of shops)
    {
        $('#shoplist').append(new Option(shop, shop));
        $('#newshoplist').append(new Option(shop, shop));
        $('#editshoplist').append(new Option(shop, shop));
    }

    // upload button converting into file button
    $("#select-files").on("click", function () {
        $("#upfile").click();
    });

    $("#select-new-logo-files").on("click", function (e) {
        e.preventDefault();
        $("#newUpload").click();
    });

    $("#select-edit-logo-files").on("click", function (e) {
        e.preventDefault();
        $("#editUpload").click();
    });

    $("body").on("change", "#newLogoImageDiv", function(e){
        var files = e.target.files;
        var done = function (url) {
            newSourceImg.src = url;
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

    $("body").on("change", "#editLogoImageDiv", function(e){
        var files = e.target.files;
        var done = function (url) {
            editSourceImg.src = url;
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


    $(document).on('click', '#newresetcheck', function () {
        var target = $(this).data('target');    
        if ($(this).is(':checked'))  
        {
            
            $("#newUpload").prop('disabled', false);
            $("#newUploadUrl").prop('disabled', true);
            $('#newUrlImgDiv').hide();
            $('#newUploadImageDiv').show();
        }
        else
        {
            $("#newUploadUrl").prop('disabled', false);
            $("#newUpload").prop('disabled', true);
            $('#newUrlImgDiv').show();
            $('#newUploadImageDiv').hide();
        }
    });

    $(document).on('click', '#editresetcheck', function () {
        var target = $(this).data('target');    
        if ($(this).is(':checked'))  
        {
            $("#editUpload").prop('disabled', false);
            $("#editUploadUrl").prop('disabled', true);
            $('#editUrlImgDiv').hide();
            $('#editUploadImageDiv').show();
        }
        else
        {
            $("#editUploadUrl").prop('disabled', false);
            $("#editUpload").prop('disabled', true);
            $('#editUrlImgDiv').show();
            $('#editUploadImageDiv').hide();
        }
    });

    $('.select2').select2({
        dropdownAutoWidth : true
    });
        
    $shopvalue = "{!! $filter['shoplist'] ?? '' !!}";
    if($shopvalue != '')
    {
        $('#shoplist').val($shopvalue).change();
    }
</script>

<script type="text/javascript">
    $("body").on("click",".close-icon",function(){
        $(".todo-compose-sidebar").removeClass('show');
    });

    $("body").on("click","#newMaterial",function(){
        $("#newModal").addClass('show');
    });

    $('body').on('change', '#newUploadUrl', function(){
        $('#newUrlImage').prop('src', $('#newUploadUrl').val());
    });

    $('body').on('change', '#editUploadUrl', function(){
        $('#editUrlImage').prop('src', $('#editUploadUrl').val());
    });

    $("body").on("click",".editMaterial",function(){
        $("#editModal").addClass('show');
        var current_object = $(this);
        var id  = current_object.data("id");
        let _url = '/user/providermaterials/' + id; 
        $('#editmaterialId').val(id);
        $.ajax({
          url: _url,
          type: "GET",
          success: function(response) {
              if(response) {
                $('#editshoplist').val(response.shoplist).change();
                $("#editdescription").val(response.description);
                $("#editbrand").val(response.brand);
                $("#editsku").val(response.sku);
                $("#editpartno").val(response.partno);
                if(response.image == "")
                {
                    $("#editUploadUrl").val(response.imageurl);
                    $('#editUrlImgDiv').show();
                    $('#editUploadImageDiv').hide();
                    $('#editUrlImage').prop('src', response.imageurl);
                }
                else
                {
                    $('#editresetcheck').prop('checked', true);
                    $("#editSourceImg").prop('src', response.image);
                    $("#editUploadUrl").prop('disabled', true);
                    $('#editUrlImgDiv').hide();
                    $('#editUploadImageDiv').show();
                }
                $("#editprice").val(response.price);
                $("#editdescription").focus();
                $("#editbrand").focus();
                $("#editsku").focus();
                $("#editpartno").focus();
                $("#editUploadUrl").focus();
                $("#editprice").focus();
              }
          }
        });
    });

  $("body").on("click",".remove-material",function(){
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

$(document).ready(function () {
  // validate
  $('#newForm').validate({
    rules: {
      description: {
        required: true,
      },
      price: {
        required: true,
        number: true,
      },
      sku: {
        required: true,
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
        required: "Please input a sku.",
        number: "Only input number."
      },
      shoplist: {
        required: "Please input a shop name.",
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

  $('#editForm').validate({
    rules: {
      description: {
        required: true,
      },
      price: {
        required: true,
        number: true,
      },
      sku: {
        required: true,
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
        required: "Please input a sku.",
        number: "Only input number."
      },
      shoplist: {
        required: "Please input a shop name.",
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