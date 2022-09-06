<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<!-- END PAGE VENDOR JS-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<!-- file upload -->
<script src="{{ asset('custom_components/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('custom_components/dropify/form-file-uploads.min.js') }}"></script>
<script src="{{ asset('js/papaparse.min.js') }}"></script>

<script type="text/javascript">

  $(document).ready(function () {
    var stopUploading = false;
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    $('body').on('click', '#uploadMaterials', function () {
        shop_id = $(this).attr("data-id");
        $('#uploadModel').modal()[0].M_Modal.options.dismissible = false;
        $('#uploadModel').modal('open');
        $('#shop_id').val(shop_id);
    });

   $('#cancelUploadBtn').click(function (e) {
        e.preventDefault();
        $('#uploadBtn').text('Send');
        $('#uploadModel').modal('close');
   });
   $('#cancelUploading').click(function (e) {
      stopUploading = true;
   });
   $('body').on('click', '#uploadBtn', function (e) {
        var materialsData;
        e.preventDefault();
        $('#progressModal').modal()[0].M_Modal.options.dismissible = false;
            $('#progressModal').modal('open');
        Papa.parse(document.getElementById('input-file-now').files[0], {
          header: true,
          dynamicTyping: true,
          complete: function(results) {
            materialsData = results.data;
            current_object = $("#uploadMaterials");
            var swalText = "{{ __('messages.You are uploading ') }}" + (materialsData.length - 1) + "{{ __('messages. records to the list') }}";

            if(!$('#customRadio1').is(':checked'))
              swalText = "{{ __('messages.You are uploading ') }}" + (materialsData.length - 1) + "{{ __('messages. records to the list. Old records will be deleted') }}";

            $('#uploadBtn').text('Upload');
            $('#cancelBtn').prop('disabled', false);
            $('#uploadBtn').prop('disabled', false);
            $('#progressModal').modal('close');
            swal({
                title: "{{ __('messages.Are you sure?') }}",
                text: swalText,
                type: "success",
                showCancelButton: true,
                dangerMode: true,
                cancelButtonClass: '#DD6B55',
                confirmButtonColor: '#1BC5BD',
                confirmButtonText: '{{ __("messages.Confirm") }}',
            },function (result) {
                if (result) {
                    $('#cancelBtn').prop('disabled', false);
                    var id = $('#shopForm #shop_id').val();
                    var add = 0;
                    if($('#customRadio1').is(':checked'))
                        add = 1;

                    var cnt = 0;
                    var materialCount = materialsData.length - 1;
                    $('#uploadBtn').text('Saving...');
                    $('#cancelBtn').prop('disabled', true);
                    $('#uploadBtn').prop('disabled', true);
                    $('#uploadingModal').modal()[0].M_Modal.options.dismissible = false;
                    $('#uploadingModal').modal('open');
                    $('#uploadingCount').text(cnt + "{{ __('messages. materials uploaded of') }}");
                    $('#uploadingTotal').text(materialCount + " {{ __('messages.materials') }}...");
                    $.ajax({
                        data: {add: add},
                        url: "clientstoreDataFile",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                        },
                        error: function (data) {
                            $('#uploadBtn').text('Upload');
                            $('#cancelBtn').prop('disabled', false);
                            $('#uploadBtn').prop('disabled', false);
                            $('#uploadingModal').modal('close');
                            return;
                        }
                    });
                    stopUploading = false;
                    addMaterial(materialsData, 0, materialCount, id, 1);
                }
                else
                {
                    $('#uploadBtn').text('Upload');
                    $('#cancelBtn').prop('disabled', false);
                    $('#uploadBtn').prop('disabled', false);
                }
            });
          }
        });
    });
    // upload button converting into file button
    $("#select-files").on("click", function () {
        $("#upfile").click();
    });

    $("#select-logo-files").on("click", function (e) {
        e.preventDefault();
        $("#Upload").click();
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

    $('#newcmaterials').click(function () {
        $('#saveBtn').html("Add");
        $(".error").html('');
        $('#typeid').val('');
        $('#sendForm').trigger("reset");
        $('#modalheader').html("{{ __('messages.New') }}" + " " + "{{ __('messages.Material') }}");
        $('#ajaxModel').modal()[0].M_Modal.options.dismissible = false;
        $('#ajaxModel').modal('open');
        $('#Upload').val('');
        $('#sourceLogoImg').prop('src', "{{ asset('imgs/upload_image.png') }}");
    });

    $('body').on('click', '.editcmaterials', function () {
        var id = $(this).data('id');
        $.get("{{ route('user.clientmaterials.index') }}" +'/' + id +'/edit', function (data) {
            $(".error").html('');
            $('#Upload').val('');
            $('#saveBtn').html("Save");
            $('#modalheader').html("{{ __('messages.Edit') }}" + " " + "{{ __('messages.Material') }}");
            $('#ajaxModel').modal()[0].M_Modal.options.dismissible = false;
            $('#ajaxModel').modal('open');
            $('#typeid').val(data.id);
            $('#provider').val(data.provider);
            $('#description').val(data.description);
            $('#price').val(data.price);
            $('#newsku').val(data.sku);
            $('#newpartno').val(data.partno);
            $('#newbrand').val(data.brand);
            $('#sourceLogoImg').prop('src', "{{ asset('imgs/upload_image.png') }}");
            $('#sourceLogoImg').prop('src', data.image);
            $('#description').focus();
            $('#newsku').focus();
            $('#newpartno').focus();
            $('#newbrand').focus();
            $('#price').focus();
            $('#provider').focus();
        })
    });

   $('#cancelBtn').click(function (e) {
        e.preventDefault();
        $(".error").html('');
        $('#ajaxModel').modal('close');
   });
   
   var i = {!! $i !!};
   var table;
   if (i == 1){
        table = $('#page-length-option').DataTable({
            serverSide: true,
            responsive: true,
            paging: true,
            ordering: false,
            info: true,
            searching: true,
            ajax: "{{ route('user.clientmaterials.index') }}",
            buttons: [
                {
                        extend: 'csv',
                        //Name the CSV
                        filename: 'file_name',
                        text: 'Customized CSV',
                }
            ],
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'provider', name: 'provider'},
                {data: 'description', name: 'description'},
                {data: 'brand', name: 'brand'},
                {data: 'sku', name: 'sku'},
                {data: 'partno', name: 'partno'},
                {data: 'price', name: 'price'},
                {data: 'image', name: 'image'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "language": {
                "paginate": {
                    "previous": "{{ __('pagination.previous') }}",
                    "next": "{{ __('pagination.next') }}",
                },
                "emptyTable": "{{ __('messages.No data available in table') }}",
                "search": "{{ __('messages.Search') }}" + ":",
                "infoEmpty":  "{{ __('messages.Showing') }}" + " 0 " + "{{ __('messages.to') }}" + " 0 " + "{{ __('messages.of') }}" + " 0 " + "{{ __('messages.entries') }}",
                "info":  "{{ __('messages.Showing') }}" + " _START_ " + "{{ __('messages.to') }}" + " _END_ " + "{{ __('messages.of') }}" + " _TOTAL_ " + "{{ __('messages.entries') }}",
                "sLengthMenu": "{{ __('messages.Show') }}" + " _MENU_ " + "{{ __('messages.entries') }}",
            },
            "fnDrawCallback": function (oSettings) {
                $('.tooltipped').tooltip();
            }
        });
    }
    else{
        table = $('#page-length-option').DataTable({
            serverSide: true,
            responsive: true,
            paging: true,
            ordering: false,
            info: true,
            searching: true,
            ajax: "{{ route('user.clientmaterials.index') }}",
            columns: [
                {data: 'provider', name: 'provider'},
                {data: 'description', name: 'description'},
                {data: 'brand', name: 'brand'},
                {data: 'sku', name: 'sku'},
                {data: 'partno', name: 'partno'},
                {data: 'price', name: 'price'},
                {data: 'image', name: 'image'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "language": {
                "paginate": {
                    "previous": "{{ __('pagination.previous') }}",
                    "next": "{{ __('pagination.next') }}",
                },
                "emptyTable": "{{ __('messages.No data available in table') }}",
                "search": "{{ __('messages.Search') }}" + ":",
                "infoEmpty":  "{{ __('messages.Showing') }}" + " 0 " + "{{ __('messages.to') }}" + " 0 " + "{{ __('messages.of') }}" + " 0 " + "{{ __('messages.entries') }}",
                "info":  "{{ __('messages.Showing') }}" + " _START_ " + "{{ __('messages.to') }}" + " _END_ " + "{{ __('messages.of') }}" + " _TOTAL_ " + "{{ __('messages.entries') }}",
                "sLengthMenu": "{{ __('messages.Show') }}" + " _MENU_ " + "{{ __('messages.entries') }}",
            },
            "fnDrawCallback": function (oSettings) {
                $('.tooltipped').tooltip();
            }
        });
    }
    function addMaterial(materialsData, cnt, materialCount, id, i)
    {
      var row = materialsData[i];
        $.ajax({
            data: { row: row},
            url: "addCMaterial",
            type: "POST",
            dataType: 'json',
            success: function (data) {
              if(data.message == "success")
              {
                cnt ++;
                $('#uploadingCount').text(cnt + "{{ __('messages. materials uploaded of') }}");
              }
              i++;
              if(i >= materialCount || stopUploading)
              {
                $('#uploadBtn').text('Upload');
                $('#cancelBtn').prop('disabled', false);
                $('#uploadBtn').prop('disabled', false);
                $('#uploadingModal').modal('close');
                $('#uploadModel').modal('close');
                table.draw();
                if(i >= materialCount)
                  M.toast({
                      html: cnt + "{{ __('messages. materials uploaded.') }} " + (materialCount - cnt) + "{{ __('messages. materials information are wrong.') }}",
                      classes: 'rounded'
                  });
                else
                  M.toast({
                      html: cnt + "{{ __('messages. materials uploaded.') }} ",
                      classes: 'rounded'
                  });
              }
              else
                addMaterial(materialsData, cnt, materialCount, id, i);
            },
            error: function(){
              $('#uploadBtn').text('Upload');
              $('#cancelBtn').prop('disabled', false);
              $('#uploadBtn').prop('disabled', false);
              $('#uploadingModal').modal('close');
              $('#uploadModel').modal('close');
              M.toast({
                    html: cnt + "{{ __('messages. materials uploaded.') }} " + (materialCount - cnt) + "{{ __('messages. materials information are wrong.') }}",
                    classes: 'rounded'
                });
            }
        });
      }
    $('body').on('keypress', '.mainInfoInput', function() {
        var id = $(this).attr('id');
        $('#error' + id).empty();
    });
    $("body").on("click",".remove-cmaterials",function(){
        var current_object = $(this);
        var id = $(this).data("id");
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
            if(result){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('user.clientmaterials.store') }}"+'/'+id,
                    success: function (data) {
                        table.draw();
                        M.toast({
                            html: data['success'],
                            classes: 'rounded'
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
    });

   $('body').on('click', '#saveBtn', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('user.clientmaterials.store') }}",
            data: new FormData(document.getElementById("sendForm")),
            type: "POST",
            processData: false,
            contentType: false,
            success: function (data) {
                $('#ajaxModel').modal('close');
                M.toast({
                    html: data['success'],
                    classes: 'rounded'
                });
                table.draw();
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
