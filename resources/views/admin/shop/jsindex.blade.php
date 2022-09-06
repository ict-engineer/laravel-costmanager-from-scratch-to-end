<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTable.js') }}"></script>

<!-- file upload -->
<script src="{{ asset('custom_components/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('custom_components/dropify/form-file-uploads.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>

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
    $('#ajaxModel').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
    });
    $('#input-file-now').dropify();
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    $('body').on('click', '#uploadMaterials', function () {
        shop_id = $(this).attr("data-id");
        $('#ajaxModel').modal({ backdrop: 'static', keyboard: false });
        $('#shop_id').val(shop_id);
    });

   $('#cancelBtn').click(function (e) {
        e.preventDefault();
        $('#ajaxModel').modal('hide');
   });
   $('body').on('click', '#uploadBtn', function (e) {
        e.preventDefault();
        $.ajax({
            
          data: new FormData(document.getElementById("shopForm")),
          url: "uploadDataFile",
          type: "POST",
          processData: false,
          contentType: false,
          beforeSend: function(){
            $('#uploadBtn').text('Sending...');
            $('#cancelBtn').prop('disabled', true);
            $('#uploadBtn').prop('disabled', true);

            },
            
          success: function (data) {
            $('#uploadBtn').text('Upload');
            $('#cancelBtn').prop('disabled', false);
            $('#uploadBtn').prop('disabled', false);
            current_object = $("#uploadMaterials");
            swal({
                title: "{{ __('messages.Are you sure?') }}",
                text: data['text'],
                type: "success",
                showCancelButton: true,
                dangerMode: true,
                cancelButtonClass: '#DD6B55',
                confirmButtonColor: '#1BC5BD',
                confirmButtonText: "{{ __('messages.Confirm') }}",
            },function (result) {
                if (result) {
                    $('#cancelBtn').prop('disabled', false);
                    var id = $('#shopForm #shop_id').val();
                    var add = 0;
                    if($('#customRadio1').is(':checked'))
                        add = 1;
                    $.ajax({
                        data: {shop_id:id, add: add},
                        url: "storeDataFile",
                        type: "POST",
                        dataType: 'json',
                        beforeSend: function(){
                            $('#uploadBtn').text('Saving...');
                            $('#cancelBtn').prop('disabled', true);
                            $('#uploadBtn').prop('disabled', true);
                        },
                        success: function (data) {
                            if(data['success'] == true)
                            {
                                toastr.success(data['text'])
                                $('#ajaxModel').modal('hide');
                            }
                            else if (data['success'] == false)
                            {
                                toastr.error(data['text'])
                            }
                            $('#uploadBtn').text('Upload');
                        },
                        error: function (data) {
                            $('#uploadBtn').text('Upload');
                            $('#cancelBtn').prop('disabled', false);
                            $('#uploadBtn').prop('disabled', false);
                            console.log(data);
                        },
                        complete: function (data) {
                            $('#uploadBtn').text('Upload');
                            $('#cancelBtn').prop('disabled', false);
                            $('#uploadBtn').prop('disabled', false);
                        }
                    });
                }
            });
          },
          error: function (data) {
              var response = JSON.parse(data.responseText);
                $('#errorfile').html(response.errors['file']);
                $('#uploadBtn').text('Upload');
                $('#cancelBtn').prop('disabled', false);
                $('#uploadBtn').prop('disabled', false);
                
          }
      });
    });
  });
</script>