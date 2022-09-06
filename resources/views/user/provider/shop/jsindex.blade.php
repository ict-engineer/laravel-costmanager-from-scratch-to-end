<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<!-- END PAGE VENDOR JS-->
<!-- END PAGE LEVEL JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<!-- file upload -->
<script src="{{ asset('custom_components/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('custom_components/dropify/form-file-uploads.min.js') }}"></script>
<script src="{{ asset('js/papaparse.min.js') }}"></script>

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

<!-- Upload Material Ajax -->
<script type="text/javascript">
  $(document).ready(function () {
    var stopUploading = false;
    table = $('#page-length-option').DataTable({
        responsive: true,
        paging: true,
        ordering: false,
        info: true,
        searching: true,
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
    $('#ajaxModel').modal({
        complete: function() { $(this).find('form')[0].reset(); } // Callback for Modal close
    });
    
    $('#input-file-now').dropify();
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    $('body').on('click', '#uploadMaterials', function () {
        shop_id = $(this).attr("data-id");
        $('#ajaxModel').modal()[0].M_Modal.options.dismissible = false;
        $('#ajaxModel').modal('open');
        $('#shop_id').val(shop_id);
    });

   $('#cancelBtn').click(function (e) {
        e.preventDefault();
        $('#uploadBtn').text('Send');
        $('#ajaxModel').modal('close');
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
                        data: {add: add, shop_id: id},
                        url: "userstoreDataFile",
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
    function addMaterial(materialsData, cnt, materialCount, id, i)
    {
      var row = materialsData[i];
        $.ajax({
            data: { row: row, shop_id: id },
            url: "addMaterial",
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
                $('#ajaxModel').modal('close');
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
              $('#ajaxModel').modal('close');
              M.toast({
                    html: cnt + "{{ __('messages. materials uploaded.') }} " + (materialCount - cnt) + "{{ __('messages. materials information are wrong.') }}",
                    classes: 'rounded'
                });
            }
        });
      }
    
  });
  
</script>