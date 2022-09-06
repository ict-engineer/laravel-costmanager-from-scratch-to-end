<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<!-- END PAGE VENDOR JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="{{ asset('js/cclient_map.js') }}"></script>
<script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqsYlbvunG8q26BV66NAVX3pGEl3lIgdI&libraries=places&callback=initMap">
</script>

<!-- Upload Material Ajax -->
<script type="text/javascript">
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var FilterStart = $('#filter_From').val();
    var FilterEnd = $('#filter_To').val();
    var date = data[0].trim();
    console.log(date);
    return false;
});

  $(document).ready(function () {
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    var fromDate = '{!! $filter["fromDate"] !!}';
    var toDate = '{!! $filter["toDate"] !!}';
    var total = '{!! $total !!}';
    $('#fromDate').val(fromDate);
    $('#toDate').val(toDate);
    $('#totalSum').text('Total: $' + total);

    $('#toDate').datepicker({
        minDate: new Date($('#fromDate').val()),
        autoClose: true,
        format: 'yyyy/mm/dd',
        container: 'body',
        onDraw: function () {
            // materialize select dropdown not proper working on mobile and tablets so we make it browser default select
            $('.datepicker-container').find('.datepicker-select').addClass('browser-default');
            $(".datepicker-container .select-dropdown.dropdown-trigger").remove()
        }
    })

    $('#fromDate').datepicker({
        maxDate: new Date($('#toDate').val()),
        autoClose: true,
        format: 'yyyy/mm/dd',
        container: 'body',
        onDraw: function () {
            // materialize select dropdown not proper working on mobile and tablets so we make it browser default select
            $('.datepicker-container').find('.datepicker-select').addClass('browser-default');
            $(".datepicker-container .select-dropdown.dropdown-trigger").remove()
        },
    })

    

    var qIType = '{!! $type !!}';
    var routeUrl = "{{ route('user.clientquotes.store') }}";
    var routeUrl1 = "{{ route('user.clientquotes.index') }}";
    
    if(qIType == 'Invoice')
    {
        routeUrl = "{{ route('user.clientinvoices.store') }}";
        routeUrl1 = "{{ route('user.clientinvoices.index') }}";
    }

    var table;
    table = $('#page-length-option').DataTable({
        serverSide: true,
        responsive: true,
        paging: true,
        ordering: false,
        info: true,
        searching: true,
        ajax: routeUrl,
        columns: [
            {data: 'date', name: 'date'},
            {data: 'quote_number', name: 'quote_number'},
            {data: 'client', name: 'client'},
            {data: 'project', name: 'project'},
            {data: 'total', name: 'total'},
            {data: 'addline', name: 'addline'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
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

    $("body").on("change","#fromDate",function(e){
        $('#toDate').datepicker({
            minDate: new Date($('#fromDate').val()),
            autoClose: true,
            format: 'yyyy/mm/dd',
            container: 'body',
            onDraw: function () {
                // materialize select dropdown not proper working on mobile and tablets so we make it browser default select
                $('.datepicker-container').find('.datepicker-select').addClass('browser-default');
                $(".datepicker-container .select-dropdown.dropdown-trigger").remove()
            },
        });
        $('#filterForm').submit();
    });

    $("body").on("change","#toDate",function(e){
        $('#fromDate').datepicker({
            maxDate: new Date($('#toDate').val()),
            autoClose: true,
            format: 'yyyy/mm/dd',
            container: 'body',
            onDraw: function () {
                // materialize select dropdown not proper working on mobile and tablets so we make it browser default select
                $('.datepicker-container').find('.datepicker-select').addClass('browser-default');
                $(".datepicker-container .select-dropdown.dropdown-trigger").remove()
            },
        });
        $('#filterForm').submit();
    });


    $("body").on("click",".generateInvoice",function(e){
        e.preventDefault();
        var id = $(this).data('id');
        swal({
            title: "{{ __('messages.Are you sure?') }}",
            text: "{{ __('messages.You are about to generate a new invoice based on this quote.') }}",
            type: "info",
            showCancelButton: true,
            dangerMode: true,
            cancelButtonClass: '#DD6B55',
            confirmButtonText: " {{ __('messages.Generate Invoice') }}",
        },function (result) {
            if(result)
            {
                $.ajax({
                    type: "get",
                    url: '/user/generateInvoice/'+id,
                    success: function (data) {
                        document.location.href = data['url'];
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
        
    });
    var d_number = 1;
    $("body").on("click",".duplicateQuote",function(e){
        e.preventDefault();
        var id = $(this).data('id');
        
        $.ajax({
            data: {type:qIType},
            type: "post",
            url: "{{ route('user.getDuplicateId') }}",
            success: function (data) {
                
                d_number = data['number'];
                var pad = "0000000";
                var str = parseInt(d_number).toString();
                
                if(str.length < 7)
                    str = pad.substring(0, pad.length - str.length) + str;

                swal({
                    title: "{{ __('messages.Are you sure?') }}",
                    text: "{{ __('messages.You are about to duplicate this ') }}"+qIType.toLowerCase()+". "+"{{ __('messages.New') }}"+" "+qIType.toLowerCase()+"{{ __('messages. will have Number: ') }}"+str,
                    type: "info",
                    showCancelButton: true,
                    dangerMode: true,
                    cancelButtonClass: '#DD6B55',
                    confirmButtonText: "{{ __('messages.Duplicate')}}" + ' ' +qIType,
                },function (result) {
                    if(result)
                    {
                        $.ajax({
                            data: {type:qIType, id:id},
                            type: "post",
                            url: "{{ route('user.duplicateQuote') }}",
                            success: function (data) {
                                table.draw();
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });
            },
            error: function (data) {
                console.log('Error:', data);
                return;
            }
        });
    });

    $("body").on("click",".remove-quote",function(){
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
                    url: routeUrl+'/'+id,
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

    $("body").on("click",".curl-top-right",function(){
        var drop = $(this).next();
        if(drop.css('display') == 'none')
        {
            drop.show();
        }
        else
            drop.hide();
    });

    $("body").on("click",".curl-top-right-comment",function(){
        var drop = $(this).next();
        if(drop.css('display') == 'none')
        {
            drop.show();
        }
        else
            drop.hide();
    });
    
    $("body").on("click",".addlineMap",function(){
        getLatLong($(this).text());
        $('#mapModel').modal()[0].M_Modal.options.dismissible = false;
        $('#mapModel').modal('open');
    });

    $("body").on("click","#cancelMapBtn",function(){
        $('#mapModel').modal('close');
    });

    $("body").on("click",".quote-status-ul li",function(){
        var div = $(this).parent().parent().prev();
        var id = $(this).parent().parent().parent().data('id');
        var className = '';
        if(div.hasClass('curl-top-right'))
            className = 'curl-top-right';
        else
            className = 'curl-top-right-comment';

        div.removeClass();
        div.addClass('quote_state_' + $(this).attr("value"));
        div.addClass(className);
        div.text($(this).text());
        $(this).parent().parent().hide();

        var url = "{{ route('user.updateQuoteStatus') }}";
        if(qIType == 'Invoice') 
            url = "{{ route('user.updateInvoiceStatus') }}";

        $.ajax({
            data: {id: id, status: $(this).attr("value")},
            type: "POST",
            url: url,
            success: function (data) {
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    $(document).mouseup(function(e) 
    {
        $( ".quote-status-div" ).each(function( index ) {
            var container = $(this);
            var btn = container.prev();
            if (!container.is(e.target) && container.has(e.target).length === 0 && !btn.is(e.target) && btn.has(e.target).length === 0) 
            {
                container.hide();
            }
        });
        $( ".quote_comment_div" ).each(function( index ) {
            var container = $(this);
            var btn = container.prev();
            if (!container.is(e.target) && container.has(e.target).length === 0 && !btn.is(e.target) && btn.has(e.target).length === 0) 
            {
                container.hide();
            }
        });
    });
    $("body").on("click",".add-update-quote",function(e){
        $comment_div = $(this).next();
        $comment_div.fadeToggle(200, function() {
        });
    });

    $("body").on("click",".btnSaveComment",function(e){
        var id = $(this).parent().parent().parent().parent().parent().data('id');
        var content = $(this).parent().prev().children(':first').val();
        var commentsDiv = $(this).parent().parent().children(':first');
        var contentDiv = $(this).parent().prev().children(':first');
        var addUpdateDiv = $(this).parent().parent().parent().parent().parent().children(':first');
        var curlDiv = $(this).parent().parent().parent().parent().parent().children(':nth-child(3)');
        $.ajax({
            data: {quoteId: id, content: content, type:qIType},
            type: "POST",
            url: "{{ route('user.saveQuoteComment') }}",
            success: function (data) {
                commentsDiv.append('<div class="justify-content-end display-flex">'+data['date']+'</div>');
                commentsDiv.append('<div style="white-space: initial;word-wrap: break-word;width: 100%;">'+data['text']+'</div>')
                contentDiv.val('');
                addUpdateDiv.html('<i class="material-icons" style="font-size:10px;">chat</i>');
                curlDiv.removeClass('curl-top-right');
                curlDiv.addClass('curl-top-right-comment');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});
</script>
