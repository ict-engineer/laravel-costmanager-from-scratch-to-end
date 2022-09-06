<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<!-- END PAGE VENDOR JS-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<!-- Upload Material Ajax -->
<script type="text/javascript">

  $(document).ready(function () {
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    $('#newproject').click(function () {
        
        $('#saveBtn').html("{{ __('messages.Add') }}");
        $('#typeid').val('');
        $('#sendForm').trigger("reset");
        $('#modalheader').html("{{ __('messages.New') }}" + " " + "{{ __('messages.Client') }}");
        $('#ajaxModel').modal()[0].M_Modal.options.dismissible = false;
        $('#ajaxModel').modal('open');
    });

    var clientsData = {};
    var validautoData = [];
    $.get("{{ route('user.getallcclients') }}", function (data) {
        for (var i = 0; i < data.length; i++) {
            clientsData[data[i]] = null; 
        }
        validautoData = data;
    })

    $('input.autocomplete').autocomplete({
        data: clientsData,
        limit: 5,
    }).change(function() {
        var autodata = "";
        for (i in validautoData) {
            if (validautoData[i].toLowerCase().match(this.value.toLowerCase())) {
                autodata = validautoData[i];
            }
        }
        this.value = autodata;
    });

    $('body').on('click', '.editproject', function () {
        var id = $(this).data('id');
        $.get("{{ route('user.clientprojects.index') }}" +'/' + id +'/edit', function (data) {
            $('#saveBtn').html("{{ __('messages.Save') }}");
            $('#modalheader').html("{{ __('messages.Edit') }}" + " " + "{{ __('messages.Client') }}");
            $('#ajaxModel').modal()[0].M_Modal.options.dismissible = false;
            $('#ajaxModel').modal('open');
            $('#typeid').val(data.id);
            $('#name').val(data.name);
            $('#client').val(data.client);
            $('#name').focus();
            $('#client').focus();
        })
    });

   $('#cancelBtn').click(function (e) {
        e.preventDefault();
        $(".error").html('');
        $('#ajaxModel').modal('close');
   });

   var i = {!! $i !!};
   if (i == 1)
        var table = $('#page-length-option').DataTable({
            serverSide: true,
            responsive: true,
            paging: true,
            ordering: false,
            info: true,
            searching: true,
            ajax: "{{ route('user.clientprojects.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'client', name: 'client'},
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
    else
        var table = $('#page-length-option').DataTable({
            serverSide: true,
            responsive: true,
            paging: true,
            ordering: false,
            info: true,
            searching: true,
            ajax: "{{ route('user.clientprojects.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'client', name: 'client'},
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
        

    $("body").on("click",".remove-project",function(){
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
                    url: "{{ route('user.clientprojects.store') }}"+'/'+id,
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
            url: "{{ route('user.clientprojects.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $(".error").html('');
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
