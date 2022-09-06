<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<!-- END PAGE VENDOR JS-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<!-- select -->
<script src="{{ asset('app-assets/vendors/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-select2.js') }}"></script>
<!-- Upload Material Ajax -->

<script>
$(".select2").select2({
     /* the following code is used to disable x-scrollbar when click in select input and
     take 100% width in responsive also */
     dropdownAutoWidth: true,
     width: '100%',
});
</script>

<script type="text/javascript">

  $(document).ready(function () {
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    // $.get("{{ route('user.getallexpensetypes') }}", function (data) {
    //     for(type of data)
    //     {
    //         var option = new Option(type, type); 
    //         $('#expensetype').append($(option));
    //     }
    // })

    $('#newfixedexpenses').click(function () {
        $('#saveBtn').html("Add");
        $('#typeid').val('');
        $('#sendForm').trigger("reset");
        $('#modalheader').html("{{ __('messages.New') }}" + " " + "{{ __('messages.Fixed Expense') }}");
        $('#ajaxModel').modal()[0].M_Modal.options.dismissible = false;
        $('#ajaxModel').modal('open');
    });

    $('body').on('click', '.editfixedexpenses', function () {
        var id = $(this).data('id');
        $.get("{{ route('user.clientfixedexpenses.index') }}" +'/' + id +'/edit', function (data) {
            $('#saveBtn').html("Save");
            $('#modalheader').html("{{ __('messages.New') }}" + " " + "{{ __('messages.Fixed Expense') }}");
            $('#ajaxModel').modal()[0].M_Modal.options.dismissible = false;
            $('#ajaxModel').modal('open');
            $('#typeid').val(data.id);
            $('#name').val(data.name);
            $('#cost').val(data.cost);
            $('#cycle').val(data.cycle).change();
            // $('#expensetype').val(data.expensetype).change();
            $('#name').focus();
            $('#cost').focus();
        })
    });

   $('#cancelBtn').click(function (e) {
        e.preventDefault();
        $(".error").html('');
        // $('#expensetype').val($("#expensetype option:first").val()).change();
        $('#cycle').val($("#cycle option:first").val()).change();
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
            ajax: "{{ route('user.clientfixedexpenses.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                // {data: 'expensetype', name: 'expensetype'},
                {data: 'name', name: 'name'},
                {data: 'cost', name: 'cost'},
                {data: 'cycle', name: 'cycle'},
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
            ajax: "{{ route('user.clientfixedexpenses.index') }}",
            columns: [
                // {data: 'expensetype', name: 'expensetype'},
                {data: 'name', name: 'name'},
                {data: 'cost', name: 'cost'},
                {data: 'cycle', name: 'cycle'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "language": {
                "paginate": {
                    "previous": "{{ __('pagination.previous') }}",
                    "next": "{{ __('pagination.next') }}",
                },
                "emptyTable": "{{ __('messages.No data available in table') }}"
            },
            "fnDrawCallback": function (oSettings) {
                $('.tooltipped').tooltip();
            }
        });
    }

    $("body").on("click",".remove-fixedexpenses",function(){
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
                    url: "{{ route('user.clientfixedexpenses.store') }}"+'/'+id,
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
    $('body').on('keypress', '.mainInfoInput', function() {
        var id = $(this).attr('id');
        $('#error' + id).empty();
    });
   $('body').on('click', '#saveBtn', function (e) {
        e.preventDefault();

        $.ajax({
            data: $('#sendForm').serialize(),
            url: "{{ route('user.clientfixedexpenses.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $(".error").html('');
                // $('#expensetype').val($("#expensetype option:first").val()).change();
                $('#cycle').val($("#cycle option:first").val()).change();
                $('#sendForm').trigger("reset");
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
