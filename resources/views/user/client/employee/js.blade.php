<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/page-account-settings.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('app-assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>

<!-- END PAGE VENDOR JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<!-- file upload -->

<!-- select -->
<script src="{{ asset('app-assets/vendors/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-select2.js') }}"></script>

<script src="{{ asset('app-assets/vendors/quill/quill.min.js') }}"></script>

<script src="{{ asset('app-assets/vendors/formatter/jquery.formatter.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-masks.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

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

<script>

    $(document).on('click', '#systemuser', function () {
        if ($(this).is(':checked'))  
        {
            $('#systemdiv').show();
        }
        else
        {
            $('#systemdiv').hide();
        }
    });
</script>

<script type="text/javascript">
$(document).ready(function () {
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
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
            ajax: "{{ route('user.clientemployees.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'image', name: 'image'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'salary', name: 'salary'},
                {data: 'cycle', name: 'cycle'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
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
            ajax: "{{ route('user.clientemployees.index') }}",
            columns: [
                {data: 'image', name: 'image'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'salary', name: 'salary'},
                {data: 'cycle', name: 'cycle'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
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
    $("body").on("click",".close-icon",function(){
        $(".todo-compose-sidebar").removeClass('show');
    });

    $("body").on("click","#newEmployee",function(){
        var numberofusers = '{!! $numberofUsers !!}';
        console.log(numberofusers);
        if(table.data().count() >= numberofusers)
        {
            swal({
                title: "{{ __('messages.Warning') }}",
                text: "{{ __('messages.You can add ') }}"+numberofusers+"{{ __('messages. employees according to your current plan. Please upgrade your plan to add more employees.') }}",
                type: 'warning',
                showCancelButton: true,
                dangerMode: true,
                cancelButtonClass: '#DD6B55',
                confirmButtonColor: '#dc3545',
                confirmButtonText: "{{ __('messages.Upgrade') }}",
                cancelButtonText: "{{ __('messages.Cancel') }}",
            },function (result) {
                if(result)
                    document.location.href = "{{ route('user.purchaseplan') }}";
            });
            return;
        }

        $(".error").html('');
        $("#ajaxModal").addClass('show');
        $('#inviteBtn').prop('disabled', true);
        $('#typeid').val(0);
        $('#sendForm').trigger("reset");
        $('#countrycodeSel').val($("#countrycodeSel option:first").val()).change();
        $('#sourceImg').attr("src", "{{ asset('imgs/user.png') }}");
        $('#systemdiv').hide();
        $('#systemuser').prop('checked', false);
        $('#cycle').val($("#cycle option:first").val()).change();
        $('saveBtn').html('Add');
        $('#modalheader').html("{{ __('messages.New') }}" + " " + "{{ __('messages.Employee') }}");
    });
    
    $("body").on("click",".editEmployee",function(){
        $(".error").html('');
        $('#sendForm').trigger("reset");
        $('#inviteBtn').prop('disabled', true);
        $('#systemdiv').hide();
        $('#systemuser').prop('checked', false);
        $('#modalheader').html("{{ __('messages.Edit') }}" + " " + "{{ __('messages.Employee') }}");
        $('#saveBtn').html('Save');
        var id = $(this).data('id');
        $('#typeid').val(id);
        $.get("{{ route('user.clientemployees.index') }}" +'/' + id +'/edit', function (data) {
            $('#name').val(data.name);
            $("#phone").val(data.phone);
            $("#salary").val(data.salary);
            if(data.image != "")
                $('#sourceImg').attr("src", document.location.origin + data.image);
            $("#imageurl").val(data.image);
            $("#cycle").val(data.cycle).change();
            $('#countrycodeSel').val(data.countryCode).change();
            if(data.hasOwnProperty('email'))
            {
              $('#userid').val(data.user_id);
              $('#systemdiv').show();
              $('#systemuser').prop('checked', true);
              $('#role').val(data.role).change();
              $('#email').val(data.email);
              $("#email").focus();  
            }
            $("#name").focus();
            $("#phone").focus();
            $("#salary").focus();
            $("#ajaxModal").addClass('show');
        })
    });

  $("body").on("click",".remove-employee",function(){
    var id = $(this).data('id');
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
            $.ajax({
                type: "DELETE",
                url: "{{ route('user.clientemployees.store') }}"+'/'+id,
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

  $("body").on("click",".invitebtn",function(){
    var current_object = $(this);
    var id  = current_object.data("id");
    var name  = current_object.data("name");
    $.ajax({
        data: {id: id},
        url: "/user/sendinvite",
        type: "POST",
        beforeSend: function(){
            M.toast({
              html: "Sending Invite to " + name + "...",
              classes: 'rounded',
              displayLength: 100000000,
          });
        },
        success: function (data) {
            var toastElement = document.querySelector('.toast');
            var toastInstance = M.Toast.getInstance(toastElement);
            toastInstance.dismiss();
          M.toast({
              html: data['success'],
              classes: 'rounded'
          });
        },
        error: function (data) {
            var toastElement = document.querySelector('.toast');
            var toastInstance = M.Toast.getInstance(toastElement);
            toastInstance.dismiss();
          M.toast({
              html: 'Invite failed.',
              classes: 'rounded'
          });
        },
        complete: function(){
            $('#uploadBtn').text('Saving...');
        },
    });
  })

  $("body").on("click","#inviteBtn",function(e){
    e.preventDefault();
    var id  = $('#typeid').val();
    $.ajax({
        data: {id: id},
        url: "/user/sendinvite",
        type: "POST",
        success: function (data) {
          M.toast({
              html: data['success'],
              classes: 'rounded'
          });
        },
        error: function (data) {
          M.toast({
              html: 'Invite failed.',
              classes: 'rounded'
          });
        }
    });
  })

  $('body').on('click', '#saveBtn', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('user.clientemployees.store') }}",
            data: $('#sendForm').serialize(),
            type: "POST",
            dataType: "json",
            success: function (data) {
                // $('#expensetype').val($("#expensetype option:first").val()).change();
                M.toast({
                    html: data['success'],
                    classes: 'rounded'
                });
                table.draw();
                $('#typeid').val(data['id']);
                $(".error").html('');
                $('#saveBtn').html('Save');
                if ($('#systemuser').is(':checked'))  
                  $('#inviteBtn').prop('disabled', false);
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


    // image upload

    var $modal = $('#uploadModal');
    var image = document.getElementById('image');
    var cropper;
    $("body").on("change", ".upfilewrapper", function(e){
        var files = e.target.files;
        var done = function (url) {
            image.src = url;
            $('#uploadModal').modal('open');
            
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

    $('#uploadModal').modal({
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

    $('#ucancelBtn').on('click', function() {
        $('#uploadModal').modal('close');
        $('#upfile').val('');
    })

    $("#usaveBtn").click(function(){
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
                    url: "{{ route('user.employeeimage') }}",
                    data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data, 'oldimage': $('imageurl').val()},
                    success: function(data){
                        $('#upfile').val('');
                        $modal.modal('close');
                        $('#sourceImg').attr("src", data['img']);
                        console.log(data['imgurl']);
                        $('#imageurl').val(data['imgurl']);
                    }
                });
            }
        });
    })
    $('body').on('keypress', '.mainInfoInput', function() {
        var id = $(this).attr('id');
        $('#error' + id).empty();
    });
//   $('#sendForm').validate({
//     rules: {
//       name: {
//         required: true,
//       },
//       phone: {
//         min:{
//           depends: function(element) {
//             var phonetmp = $('#newphone').val();
//             var phone = phonetmp.toString().replace(/[^0-9]/g,'');
//             if(phone.length < 10)
//               return true;
//           }
//         }
//       },
//       salary: {
//         required: true,
//         number: true,
//       },
//       email: {
//         email: true,
//         required: {
//           depends: function(element) {
//             var flag = $('#newsystemuser').is(":checked");
//             if(flag == true)
//             {
//               var text = $('#newemail').val();
//               if(text == "" || text == null)
//                return true;
//             }
//             return false;
//           }
//         }
//       }
//     },
//     messages: {
//         name: {
//         required: "Please input a name."
//       },
//       phone: {
//         min: "Please input correct phone number.",
//       },
//       salary: {
//         required: "Please input a salary.",
//         number: "Only input number."
//       },
//       email: {
//         required: "Please input a email.",
//         number: "Please input a valid email."
//       }
//     },
//     errorElement : 'div',
//     errorPlacement: function(error, element) {
//         var placement = $(element).data('error');
//         if (placement) {
//             $(placement).append(error)
//         } else {
//         error.insertAfter(element.parent());
//         }
//     }
//   });
//   $('#editForm').validate({
//     rules: {
//       name: {
//         required: true,
//       },
//       phone: {
//         min:{
//           depends: function(element) {
//             var phonetmp = $('#editphone').val();
//             var phone = phonetmp.toString().replace(/[^0-9]/g,'');
//             if(phone.length < 10)
//               return true;
//           }
//         }
//       },
//       salary: {
//         required: true,
//         number: true,
//       },
//       email: {
//         email: true,
//         required: {
//           depends: function(element) {
//             var flag = $('#editsystemuser').is(":checked");
//             if(flag == true)
//             {
//               var text = $('#editemail').val();
//               if(text == "" || text == null)
//                return true;
//             }
//             return false;
//           }
//         }
//       }
//     },
//     messages: {
//         name: {
//         required: "Please input a name."
//       },
//       phone: {
//         min: "Please input correct phone number.",
//       },
//       salary: {
//         required: "Please input a salary.",
//         number: "Only input number."
//       },
//       email: {
//         required: "Please input a email.",
//         number: "Please input a valid email."
//       }
//     },
//     errorElement : 'div',
//     errorPlacement: function(error, element) {
//         var placement = $(element).data('error');
//         if (placement) {
//             $(placement).append(error)
//         } else {
//         error.insertAfter(element.parent());
//         }
//     }
//   });
});
</script>
