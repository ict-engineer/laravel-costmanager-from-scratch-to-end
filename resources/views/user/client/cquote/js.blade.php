<script src="{{ asset('custom_components/function_table/js/jquery-ui.js') }}"></script>

<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script src="{{ asset('app-assets/vendors/formatter/jquery.formatter.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-masks.js') }}"></script>

<!-- select -->
<script src="{{ asset('app-assets/vendors/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/form-select2.js') }}"></script>
<script src="{{ asset('js/number_to_text/written-number.min.js') }}"></script>
<!-- Upload Material Ajax -->
<script src="https://rawgit.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>

<script src="{{ asset('custom_components/function_table/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/core.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>

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


<script type="text/javascript">
    // var dists = {};
    var cservicesData = {};
    var cservicesDatas = [];
    var employeesData = {!! $employees !!};
    var fixedTotal = 0;
    var subTotal = 0;
    var servicesTotal = 0;
    var itemTotal = 0;
    var employeesTotal = 0;
    var Total = 0;
    var itemCount = 0;
    var shopdaysTotal = 0;
    var unpreventedTotal = 0;
    var sendData = {};
    var errorMessage = false;
    var dateText = '{!! $date !!}';
    var footerText = '{!! $footerText !!}';
    var logoimage = '{!! $logoimage !!}';
    var materialUlData;
    var isChanged = false;
    var qIType = '{!! $type !!}'
    var routeUrl = "{{ route('user.clientquotes.store') }}";

    //init provider autocomplete on materials filter
    var providers = {!! $providers !!};
    
    for(provider of providers)
    {
        $('#filter-provider').append(new Option(provider, provider));
    }

    if(qIType == 'Invoice')
        routeUrl = "{{ route('user.clientinvoices.store') }}";

    $('#dateText').text(dateText);
    $('#footerText').text(footerText);
    $('#quoteLogoImage').attr("src", logoimage);

    $(document).ready(function () {
        // const countryValue = "{!! $quote->countryCode ?? '' !!}";
        // if(countryValue !== '') {
        //     $('#countrycodeSel').val(countryValue).change();
        // }
        // const countryOldValue = "{!! old( 'countryCode') !!}";
        // if(countryOldValue !== '') {
        //     $('#countrycodeSel').val(countryOldValue).change();
        // }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var clientsData = {};
        $.get("{{ route('user.getallcclients') }}", function (data) {
            for (var i = 0; i < data.length; i++) {
                clientsData[data[i]] = null; 
            }
        })

        $('#client').bind('keydown', function (event) {
            if (event.keyCode === $.ui.keyCode.TAB) {
                event.preventDefault();
                if(event.shiftKey) {
                    $('#quoteNumber').focus();
                }
                else
                    $('#companyname').focus();
            }
        }).autocomplete({
            data: clientsData,
            limit: 5,
        })

        $.get("{{ route('user.getFixedExpenseSum') }}", function (data) {
            fixedTotal = data;
        })

        $.get("{{ route('user.getallcservices') }}", function (data) {
            cservicesDatas = data;
            for (var i = 0; i < data.length; i++) {
                cservicesData[data[i].name] = null; 
            }
        })
        
        var projectsData = [];
        $('#project').editableSelect();

        $('#client').change(function() {
            $('#companyname').prop( "readonly", false);
            $('#phone').prop( "readonly", false);
            $('#countrycodeSel').prop( "readonly", false);
            $('#email').prop( "readonly", false);
            $.ajax({
                data: {name: $('#client').val()},
                url: "{{ route('user.getcclientinfobyname') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if(typeof data.name != 'undefined')
                    {
                        $('#countrycodeSel').val(data.countryCode).change();
                        $('#phone').val(data.phone);
                        $('#phone').focus();
                        $('#email').val(data.email);
                        $('#email').focus();
                        $('#companyname').val(data.companyname);
                        $('#companyname').focus();
                        $('#addline').val(data.addline);
                        $('#addline').focus();
                        $('#project').focus();

                        if($('#companyname') != "" && $('#companyname') != null)
                            $('#companyname').prop( "readonly", true );
                        if($('#phone') != "" && $('#phone') != null)
                            $('#phone').prop( "readonly", true );
                        if($('#countryCode') != "" && $('#countryCode') != null)
                            $('#countrycodeSel').prop( "readonly", true );
                        if($('#email') != "" && $('#email') != null)
                            $('#email').prop( "readonly", true );
                        $('#addline').prop( "readonly", true );
                        
                        $.ajax({
                            data: {name: $('#client').val()},
                            url: "{{ route('user.getclientprojects') }}",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                $('#project').next().empty();
                                for (var i = 0; i < data.length; i++) {
                                    $('#project').editableSelect('add', function () {                                
                                        $(this).attr('value', data[i]);
                                        $(this).text(data[i]);                                                           
                                    });
                                }
                            }
                        });
                    }
                    else
                    {
                        $('#countrycodeSel').val($("#countrycodeSel option:first").val()).change();
                        $('#phone').val('');
                        $('#email').val('');
                        $('#companyname').val('');
                        $('#project').val('');
                        $('#companyname').focus();
                    }
                },
                error: function (data) {
                }
            });
        })
        
        // $.ajax({
        //     url: "{{ route('user.getAllShops') }}",
        //     type: "get",
        //     success: function (data) {
        //         for(var i = 0; i < data['shops'].length; i ++)
        //             getDistance(data['shops'][i].lat, data['shops'][i].lng, data['address'], data['shops'][i].id);
        //     }
        // });

        const quote_number = "{!! $quote_number ?? '' !!}";
        if(quote_number != '')
        {
            var pad = "0000000";
            var str = parseInt(quote_number).toString();
            
            if(str.length < 7)
                str = pad.substring(0, pad.length - str.length) + str;
            $('#quoteNumber').val(str);
        }

        const quote_number1 = "{!! $quote->quote_number ?? '' !!}";
        if(quote_number1 != '')
        {
            var pad = "0000000";
            var str = parseInt(quote_number1).toString();
            
            if(str.length < 7)
                str = pad.substring(0, pad.length - str.length) + str;
            $('#quoteNumber').val(str);
        }

        $('body').on('change', '#quoteNumber', function() {

            if($('#quoteNumber').val() == null || $('#quoteNumber').val() == '')
                return;
            var pad = "0000000";
            var str = parseInt($('#quoteNumber').val()).toString();
            
            if(str.length < 7)
                str = pad.substring(0, pad.length - str.length) + str;
            $('#quoteNumber').val(str);
        });

        const quoteId = "{!! $quote->id ?? '' !!}";
        if(quoteId != '')
        {
            if($('#companyname') != "" && $('#companyname') != null)
                $('#companyname').prop( "readonly", true );
            if($('#phone') != "" && $('#phone') != null)
                $('#phone').prop( "readonly", true );
            if($('#countryCode') != "" && $('#countryCode') != null)
                $('#countrycodeSel').prop( "readonly", true );
            if($('#email') != "" && $('#email') != null)
                $('#email').prop( "readonly", true );
            
            $.ajax({
                data: {name: $('#client').val()},
                url: "{{ route('user.getclientprojects') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#project').next().empty();
                    for (var i = 0; i < data.length; i++) {
                        $('#project').editableSelect('add', function () {                                
                            $(this).attr('value', data[i]);
                            $(this).text(data[i]);                                                           
                        });
                    }
                }
            });
            const showPreview = "{!! $showPreview ?? '' !!}"

            if(showPreview != '')
            {
                $('#editQuoteDiv').hide();
                $('#previewQuoteDiv').show();
            }

            $('#quoteid').val(quoteId);

            $.get("{{ route('user.getFixedExpenseSum') }}", function (data) {
                fixedTotal = data;
                $.ajax({
                    url: "{{ route('user.getQuoteInfo') }}",
                    type: "post",
                    data: {id: quoteId},
                    success: function (data) {
                        var groups = data['data'];
                        for (var i = 0; i < groups.length; i ++)
                        {
                            addGroup();
                            var tr = $('#fGroups').children().eq(i).children(':first').children(':nth-child(2)').children(':first');
                            for (var j = 0; j < groups[i]['items'].length; j ++)
                            {
                                tr.children(".ftField").children().first().val("   ");
                                addNew(tr);
                                var smtr = tr.parent().children().eq(j * 2 + 1).children(':first').children(':first').children(':first').children(':last');
                                for (var k = 0; k < groups[i]['items'][j]['materials'].length; k ++)
                                {
                                    addNewSubitem(smtr, false);
                                }
                            }
                        }
                        for ( var i = 0; i < $('#fGroups').children().length; i ++)
                        {
                            $('#fGroups').children().eq(i).removeClass();
                            $('#fGroups').children().eq(i).addClass('fGroup');
                            $('#fGroups').children().eq(i).addClass(groups[i]['color']);
                            var table = $('#fGroups').children().eq(i).children(':first');
                            table.children(':first').children(':first').children(':nth-child(2)').children(':first').children(':first').val(groups[i]['name']);
                            var tbody = table.children(':nth-child(2)');
                            for( var j = 0; j < tbody.children().length - 1; j += 2)
                            {  f
                                var itembody = tbody.children().eq(j);
                                var itemData = groups[i]['items'][j / 2];
                                itembody.children(':nth-child(3)').children(':nth-child(2)').val(itemData['name']);
                                itembody.children(':nth-child(4)').children(':first').val(z(itemData['quantity']));
                                itembody.children(':nth-child(5)').children(':first').val(z1(itemData['cost'], '$'));
                                itembody.children(':nth-child(6)').children(':first').val(z(itemData['utility']) + '%');
                                itembody.children(':nth-child(7)').children(':first').val(z1(itemData['total'], '$'));

                                var materialsbody = tbody.children().eq(j + 1).children(':first').children(':first').children(':first').children(':nth-child(2)');
                                for(var k = 0; k < materialsbody.children().length; k ++)
                                {
                                    var material = groups[i]['items'][j / 2]['materials'][k];
                                    var materialbody = materialsbody.children().eq(k);
                                    materialbody.children(':nth-child(2)').children(':first').children(':first').val(material['name']);
                                    materialbody.children(':nth-child(3)').children(':first').val(material['provider']);
                                    materialbody.children(':nth-child(4)').children(':first').val(z(material['quantity']));
                                    materialbody.children(':nth-child(5)').children(':first').val(z1(material['cost'], '$'));
                                    materialbody.children(':nth-child(6)').children(':first').val(z1(material['total'], '$'));
                                }
                            }
                        }
                        
                        var services = data['services'];
                        if(services.length)
                        {
                            addService();
                            for (var j = 0; j < services.length; j ++)
                            {
                                var serviceDiv = $('#serviceGroup > .table > tbody');
                                var tr = serviceDiv.children(':last');
                                tr.children(".ftField").children().first().children().first().val("   ");
                                addNew(tr);
                            }
                            var serviceDiv = $('#serviceGroup > .table > tbody');
                            for(var i = 0; i < serviceDiv.children().length - 1; i += 2)
                            {
                                var itembody = serviceDiv.children().eq(i);
                                var itemData = services[i / 2];
                                itembody.children(':nth-child(3)').children(':nth-child(2)').children(':first').val(itemData['name']);
                                itembody.children(':nth-child(4)').children(':first').val(itemData['provider']);
                                itembody.children(':nth-child(5)').children(':first').val(z1(itemData['cost'], '$'));
                                itembody.children(':nth-child(6)').children(':first').val(z(itemData['utility']) + '%');
                                itembody.children(':nth-child(7)').children(':first').val(z1(itemData['price'], '$'));
                            }
                        }

                        var employees = data['employees'];
                        if(employees.length)
                        {
                            addEmployee();
                            for (var j = 0; j < employees.length; j ++)
                            {
                                var employeeDiv = $('#employeeGroup > .table > tbody');
                                var tr = employeeDiv.children(':last');
                                addNew(tr, true);
                            }
                            var employeeDiv = $('#employeeGroup > .table > tbody');
                            for(var i = 0; i < employeeDiv.children().length - 1; i += 2)
                            {
                                var itembody = employeeDiv.children().eq(i);
                                var itemData = employees[i / 2];
                                itembody.children(':nth-child(3)').children(':nth-child(2)').children(':first').val(itemData['name']);
                                itembody.children(':nth-child(4)').children(':first').val(itemData['hours']);
                                itembody.children(':nth-child(5)').children(':first').val(z1(itemData['cost'], '$'));
                                var total = parseFloat(itemData['hours']) * parseFloat(itemData['cost']);
                                total = total.toFixed(2);
                                itembody.children(':nth-child(6)').children(':first').val(z1(total, '$'));
                            }
                        }
                        const shopdays = "{!! $quote->shopdays ?? '' !!}";
                        const discount = "{!! $quote->discount ?? '' !!}";
                        const unprevented = "{!! $quote->unprevented ?? '' !!}";
                        const advance = "{!! $quote->advance ?? '' !!}";
                        if(shopdays != 0 && shopdays != '')
                            $('#shopdaysCheck').prop('checked', true);
                        if(discount != 0 && discount != '')
                            $('#discountCheck').prop('checked', true);
                        if(unprevented != 0 && unprevented != '')
                            $('#unpreventedCheck').prop('checked', true);
                        if(advance != 0 && advance != '')
                            $('#advanceCheck').prop('checked', true);
                        $('#shopdaysInput').val(shopdays);
                        $('#discountInput').val(z(discount) + '%');
                        $('#unpreventedInput').val(z(unprevented) + '%');
                        $('#advanceInput').val(z(advance) + '%');
                        getTotalSum();
                        getAdvance();

                        if(showPreview != '')
                        {
                            getSendData();
                            if(sendData['quoteNumber'] != '' && sendData['quoteNumber'] != null)
                                $('#preQuoteNumber').text(qIType + ' No. ' + sendData['quoteNumber']);
                            if(sendData['client'] != '' && sendData['client'] != null)
                                $('#preClient').text('Att: ' + sendData['client']);
                            if(sendData['phone'] != '' && sendData['phone'] != "(   )    -    " && sendData['phone'] != null)
                                $('#prePhone').text("{{ __('messages.Phone') }}" + ': ' + sendData['countryCode'] + ' ' + sendData['phone']);
                            if(sendData['email'] != '' && sendData['email'] != null)
                                $('#preEmail').text("{{ __('messages.Mail') }}" + ': ' + sendData['email']);
                            if(sendData['addline'] != '' && sendData['addline'] != null)
                                $('#preAddress').text(sendData['addline']);
                            if(sendData['project'] != '' && sendData['project'] != null)
                                $('#preProject').text(sendData['project']);
                            if(sendData['companyname'] != '' && sendData['companyname'] != null)
                                $('#preCompany').text(sendData['companyname']);
                            
                            if($('#discountCheck').prop("checked") == true)
                                $('#preDiscountHeader').text("{{ __('messages.Discount') }}" + ' ' + z($('#discountInput').val()))
                            if($('#advanceCheck').prop("checked") == true)
                                $('#preAdvanceHeader').text("{{ __('messages.Advance') }}" + ' ' + z($('#advanceInput').val()))
                            setPreviewTable();
                        }
                    }
                });
            })
            isChanged = false;
        }
    });
    
    function getMaterials(currentObj)
    {
        if(currentObj.val() != null && currentObj.val() != "")
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: {value: currentObj.val(), sort: $('#filter-sort').val(), provider: $('#filter-provider').val()},
                url: "{{ route('user.getMaterialbyName') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    var container = currentObj.parent().children(':nth-child(2)');
                    container.empty();
                    materialUlData = data['data'];
                    console.log(materialUlData);
                    for (var i = 0; i <  materialUlData.length; i++) {
                        var autocompleteOption = $('<li class="material-item" style="display:flex;"></li>');
                        var ele = data['data'][i];
                        var symbol = '$';
                        if(ele.currency == "GBP")
                            symbol = '£';
                        else if (ele.currency == "EUR")
                            symbol = '€';
                        else if (ele.currency == 'RUB')
                            symbol = '₽';
                        else if (ele.currency == 'JPY')
                            symbol = '¥';
                        else if (ele.currency == 'RMB')
                            symbol = '¥';

                        if(ele.brand == null || ele.brand == '')
                            var text = ele.description + '/' + ele.shopname + '/' + z1(ele.price, symbol) + '/Dist:' + z(ele.distance) + 'km';
                        else
                            var text = ele.description + '/' + ele.shopname + '/' + z1(ele.price, symbol) + '/' + ele.brand + '/' + z(ele.distance) + 'km';
                        if($('#filter-image').prop("checked"))
                            autocompleteOption.append('<img width="50" height="50" style="display:none;" src="'+ ele.image +'"></img><span>' + text + '</span>');
                        else
                            autocompleteOption.append('<span>' + text + '</span>');
                        container.append(autocompleteOption);
                    }
                    container.show();
                },
                error: function (data) {
                }
            });
        }
    }

    function clickMaterials(currentObj)
    {
        getMaterials(currentObj);
        var container = currentObj.parent().children(':nth-child(2)');
        if(container.css('display') == 'none')
        {
            container.show();
        }
        else
        {
            container.hide();
        }
    }
    $(document).mouseup(function(e) 
    {
        var count = 0;

        $("#filterRow" ).each(function( index ) {
            var container = $(this);
            if (container.has(e.target).length) 
            {
                count++;
            }
        });
        if(!count)
            $('#filterRow').hide();

        $( ".material-ul" ).each(function( index ) {
            var container = $(this);
            if (!container.is(e.target) && container.has(e.target).length === 0) 
            {
                container.hide();
            }
        });
    });
    $("body").on("click",".clientSideItem",function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        if(isChanged)
        {
            Swal.fire({
            title: "{{ __('messages.Are you sure?') }}",
            text: "{{ __('messages.You haven`t saved, still want to go out?') }}",
            icon: 'warning',
            showCancelButton: true,
            showDenyButton: true,
            denyButtonColor: '#00bcd4',
            confirmButtonColor: '#dc3545',
            confirmButtonText: '{{ __("messages.Exit") }}',
            denyButtonText: '{{ __("messages.Save & Exit") }}',
            }).then((result) => {
                if(result.isDismissed)
                {
                }
                else if(result.isDenied)
                {
                    getSendData();
                    if(!errorMessage)
                    {
                        $.ajax({
                            data: sendData,
                            url: routeUrl,
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                isChanged = false;
                                M.toast({
                                    html: qIType + ' saved successfully!',
                                    classes: 'rounded'
                                });
                                document.location.href = url;
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
                    }
                    else
                    {
                        Swal.fire({
                            title: "{{ __('messages.Warning') }}",
                            text: "{{ __('messages.You must input correct values for all fields in the table.') }}",
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'Ok',
                        });
                    }
                }
                else
                {
                    document.location.href = url;
                }
            });
        }
        else
            document.location.href = url;
    });
    $("body").on("click",".clientUserItem",function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        if(isChanged)
        {
            Swal.fire({
            title: "{{ __('messages.Are you sure?') }}",
            text: "{{ __('messages.You haven`t saved, still want to go out?') }}",
            icon: 'warning',
            showCancelButton: true,
            showDenyButton: true,
            denyButtonColor: '#00bcd4',
            confirmButtonColor: '#dc3545',
            confirmButtonText: '{{ __("messages.Exit") }}',
            denyButtonText: '{{ __("messages.Save & Exit") }}',
            }).then((result) => {
                if(result.isDismissed)
                {
                }
                else if(result.isDenied)
                {
                    getSendData();
                    if(!errorMessage)
                    {
                        $.ajax({
                            data: sendData,
                            url: routeUrl,
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                isChanged = false;
                                M.toast({
                                    html: qIType + ' saved successfully!',
                                    classes: 'rounded'
                                });
                                if(url == "{{ route('logout') }}")
                                {
                                    event.preventDefault();
                                    document.getElementById('logout-form').submit();
                                }
                                else
                                    document.location.href = url;
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
                    }
                    else
                    {
                        Swal.fire({
                            title: "{{ __('messages.Warning') }}",
                            text: "{{ __('messages.You must input correct values for all fields in the table.') }}",
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'Ok',
                        });
                    }
                }
                else
                {
                    if(url == "{{ route('logout') }}")
                    {
                        event.preventDefault();
                        document.getElementById('logout-form').submit();
                    }
                    else
                        document.location.href = url;
                }
            });
        }
        else
        {
            if(url == "{{ route('logout') }}")
            {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }
            else
                document.location.href = url;
        }
    });

    $("body").on("click","#copyLinkBtn",function(e){

        $('.quoteId').val($('#quoteid').val());
        $('.showMaterial').val(Number($('#checkPreMaterials').prop("checked")));
        $('.showService').val(Number($('#checkPreServices').prop("checked")));
        $('.showEmployee').val(Number($('#checkPreEmployees').prop("checked")));
        $('.showOnlyTotal').val(Number($('#checkPreTotal').prop("checked")));
        $('.messageContent').val($('.print-area').html());
        var dummy = document.createElement('input');
        var d = new Date();
        var passhash = CryptoJS.MD5($('#quoteid').val() + d.getTime()).toString();
        if($('#quoteid').val() == null || $('#quoteid').val() == '' || $('#quoteid').val() < 0)
        {
            Swal.fire({
                title: "{{ __('messages.Warning') }}",
                text: "{{ __('messages.You have to create first.') }}",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ok',
            });
            return;
        }

        if(isChanged)
        {
            Swal.fire({
                title: "{{ __('messages.Warning') }}",
                text: "{{ __('messages.You have to save first.') }}",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ok',
            });
            return;
        }
        
        $.ajax({
            data: $('#whatsappForm').serialize() + '&type=' + qIType + '&urlName=' + passhash + '&isSend=0',
            url: "{{ route('user.sendByWhatsapp') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                document.body.appendChild(dummy);
                dummy.value = window.location.origin + '/public_quote/' + passhash;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);
                M.toast({
                    html: 'Copied to clipboard',
                    classes: 'rounded'
                });
            },
            error: function (data) {
            }
        });
    });

    $("body").on("click","#cancelBtn",function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        if(isChanged)
        {
            Swal.fire({
            title: "{{ __('messages.Are you sure?') }}",
            text: "{{ __('messages.You haven`t saved, still want to go out?') }}",
            icon: 'warning',
            showCancelButton: true,
            showDenyButton: true,
            denyButtonColor: '#00bcd4',
            confirmButtonColor: '#dc3545',
            confirmButtonText: '{{ __("messages.Exit") }}',
            denyButtonText: '{{ __("messages.Save & Exit") }}',
            }).then((result) => {
                if(result.isDismissed)
                {
                }
                else if(result.isDenied)
                {
                    getSendData();
                    if(!errorMessage)
                    {
                        $.ajax({
                            data: sendData,
                            url: routeUrl,
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                isChanged = false;
                                M.toast({
                                    html: qIType + ' saved successfully!',
                                    classes: 'rounded'
                                });
                                document.location.href = url;
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
                    }
                    else
                    {
                        Swal.fire({
                            title: "{{ __('messages.Warning') }}",
                            text: "{{ __('messages.You must input correct values for all fields in the table.') }}",
                            icon: 'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'Ok',
                        });
                    }
                }
                else
                {
                    document.location.href = url;
                }
            });
        }
        else
            document.location.href = url;
    });

    $("body").on("click","#btnCreate",function(){
        $('.card-alert').hide();
        $('.error').empty();
    });

    $("body").on("keyup",".material-field",function(){
        getMaterials($(this));
        
    });

    $("body").on("click",".material-field",function(){
        clickMaterials($(this));
        $('#filterRow').show();
    });

    $("body").on("mouseover",".material-item",function(){
        if($('#filter-image').prop('checked'))
            $(this).children(':first').show();
    });

    $("body").on("mouseout",".material-item",function(){
        if($('#filter-image').prop('checked'))
            $(this).children(':first').hide();
    });

    $("body").on("click",".material-item",function(){
        var curObj = $(this);
        var tr = curObj.parent().parent().parent().parent();
        var i = curObj.parent().children().index(curObj);
        if(i < materialUlData.length)
        {
            tr.children(':nth-child(2)').children(':first').children(':first').val(materialUlData[i].description);
            tr.children(':nth-child(3)').children(':first').val(materialUlData[i].shopname);

            var symbol = '$';
            if(materialUlData[i].currency == "GBP")
                symbol = '£';
            else if (materialUlData[i].currency == "EUR")
                symbol = '€';
            else if (materialUlData[i].currency == 'RUB')
                symbol = '₽';
            else if (materialUlData[i].currency == 'JPY')
                symbol = '¥';
            else if (materialUlData[i].currency == 'RMB')
                symbol = '¥';
            
            tr.children(':nth-child(4)').children(':first').val('1');
            tr.children(':nth-child(5)').children(':first').val(symbol + materialUlData[i].price).change();
        }
        
        curObj.parent().hide();
    });

    // async function getDistance(lat1, lon1, address, id){
    //     var geocoder = new google.maps.Geocoder();
        
    //     let promise = new Promise((resolve, reject) => {
    //         geocoder.geocode( { address: address }, function(results, status) {
    //             if (status == google.maps.GeocoderStatus.OK) {
    //                 var lat2 = results[0].geometry.location.lat();
    //                 var lon2 = results[0].geometry.location.lng();
    //                 const R = 6371; // metres
    //                 const a1 = lat1 * Math.PI/180; // φ, λ in radians
    //                 const a2 = lat2 * Math.PI/180;
    //                 const b1 = (lat2-lat1) * Math.PI/180;
    //                 const b2 = (lon2-lon1) * Math.PI/180;

    //                 const a = Math.sin(b1/2) * Math.sin(b1/2) +
    //                         Math.cos(a1) * Math.cos(a2) *
    //                         Math.sin(b2/2) * Math.sin(b2/2);
                    
    //                 const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                    
    //                 var dist = R * c; // in metres
    //                 dist = dist.toFixed(3);
    //                 dists[id] = dist;
    //                 resolve(dist);
    //             }
    //         });
    //     });
    //     var result1 = await promise;
    //     return result1;
    // }
    
    function getSendData()
    {
        sendData = {};
        errorMessage = false;
        sendData['id'] = $('#quoteid').val();
        sendData['client'] = $('#client').val();
        sendData['quoteNumber'] = $('#quoteNumber').val();
        sendData['companyname'] = $('#companyname').val();
        sendData['phone'] = $('#phone').val();
        sendData['countryCode'] = '52';
        sendData['addline'] = $('#addline').val();
        sendData['project'] = $('#project').val();
        sendData['email'] = $('#email').val();
        sendData['discount'] = $('#discountInput').val().substring(0, $('#discountInput').val().length - 1);
        sendData['unprevented'] = $('#unpreventedInput').val().substring(0, $('#unpreventedInput').val().length - 1);
        sendData['shopdays'] = $('#shopdaysInput').val().replaceAll(',', '');
        sendData['advance'] = $('#advanceInput').val().substring(0, $('#advanceInput').val().length - 1);
        sendData['total'] = $('#sumTotal').text().substring(1, $('#sumTotal').text().length).replaceAll(',', '');
        var groups = [];
        for ( var i = 0; i < $('#fGroups').children().length; i ++)
        {
            var table = $('#fGroups').children().eq(i).children(':first');
            var groupData = {};
            $colors = $('#fGroups').children().eq(i).attr('class').split(' ');
            groupData['name'] = table.children(':first').children(':first').children(':nth-child(2)').children(':first').children(':first').val();
            errorMessage = checkError(groupData['name'], table.children(':first').children(':first').children(':nth-child(2)').children(':first').children(':first')) || errorMessage;
            groupData['color'] = $colors[1];
            var tbody = table.children(':nth-child(2)');
            var itemDatas = [];
            for( var j = 0; j < tbody.children().length - 1; j += 2)
            {  
                var itembody = tbody.children().eq(j);
                var itemData = {};
                itemData['name'] = itembody.children(':nth-child(3)').children(':nth-child(2)').val();
                errorMessage = checkError(itemData['name'], itembody.children(':nth-child(3)').children(':nth-child(2)')) || errorMessage;
                itemData['quantity'] = itembody.children(':nth-child(4)').children(':first').val().replaceAll(",", "");
                errorMessage = checkError(itemData['quantity'], itembody.children(':nth-child(4)').children(':first')) || errorMessage;
                itemData['cost'] = itembody.children(':nth-child(5)').children(':first').val().substring(1, itembody.children(':nth-child(5)').children(':first').val().length).replaceAll(",", "");
                errorMessage = checkError1(itemData['cost'], itembody.children(':nth-child(5)').children(':first')) || errorMessage;
                itemData['utility'] = itembody.children(':nth-child(6)').children(':first').val().substring(0, itembody.children(':nth-child(6)').children(':first').val().length - 1).replaceAll(",", "");
                errorMessage = checkError1(itemData['utility'], itembody.children(':nth-child(6)').children(':first')) || errorMessage;
                itemData['total'] = itembody.children(':nth-child(7)').children(':first').val().substring(1, itembody.children(':nth-child(7)').children(':first').val().length).replaceAll(",", "");
                errorMessage = checkError1(itemData['total'], itembody.children(':nth-child(7)').children(':first')) || errorMessage;
                itemDatas.push(itemData);

                var materialsbody = tbody.children().eq(j + 1).children(':first').children(':first').children(':first').children(':nth-child(2)');
                var materials = [];
                for(var k = 0; k < materialsbody.children().length; k ++)
                {
                    var materialbody = materialsbody.children().eq(k);
                    var material = {};
                    material['description'] = materialbody.children(':nth-child(2)').children(':first').children(':first').val();
                    errorMessage = checkError(material['description'], materialbody.children(':nth-child(2)').children(':first').children(':first')) || errorMessage;
                    material['provider'] = materialbody.children(':nth-child(3)').children(':first').val();
                    errorMessage = checkError(material['provider'], materialbody.children(':nth-child(3)').children(':first')) || errorMessage;
                    material['quantity'] = materialbody.children(':nth-child(4)').children(':first').val().replaceAll(",", "");
                    errorMessage = checkError1(material['quantity'], materialbody.children(':nth-child(4)').children(':first')) || errorMessage;
                    material['cost'] = materialbody.children(':nth-child(5)').children(':first').val().substring(1, materialbody.children(':nth-child(5)').children(':first').val().length).replaceAll(",", "");
                    errorMessage = checkError1(material['cost'], materialbody.children(':nth-child(5)').children(':first')) || errorMessage;
                    errorMessage = checkError1(materialbody.children(':nth-child(6)').children(':first').val().substring(1, materialbody.children(':nth-child(6)').children(':first').val().length).replaceAll(",", ""), materialbody.children(':nth-child(6)').children(':first')) || errorMessage;
                    materials.push(material);
                }
                itemData['materials'] = materials;
            }
            groupData['items'] = itemDatas;
            groups.push(groupData);
        }
        sendData['groups'] = groups;
        var services = [];
        if($('#serviceGroup').length)
        {
            var serviceDiv = $('#serviceGroup > .table > tbody');
            for(var i = 0; i < serviceDiv.children().length - 1; i += 2)
            {
                var itembody = serviceDiv.children().eq(i);
                var service = {};
                service['name'] = itembody.children(':nth-child(3)').children(':nth-child(2)').children(':first').val();
                errorMessage = checkError(service['name'], itembody.children(':nth-child(3)').children(':nth-child(2)').children(':first')) || errorMessage;
                service['provider'] = itembody.children(':nth-child(4)').children(':first').val();
                errorMessage = checkError(service['provider'], itembody.children(':nth-child(4)').children(':first')) || errorMessage;
                service['cost'] = itembody.children(':nth-child(5)').children(':first').val().substring(1, itembody.children(':nth-child(5)').children(':first').val().length).replaceAll(",", "");
                errorMessage = checkError1(service['cost'], itembody.children(':nth-child(5)').children(':first')) || errorMessage;
                service['utility'] = itembody.children(':nth-child(6)').children(':first').val().substring(0, itembody.children(':nth-child(6)').children(':first').val().length - 1).replaceAll(",", "");
                errorMessage = checkError1(service['utility'], itembody.children(':nth-child(6)').children(':first')) || errorMessage;
                service['price'] = itembody.children(':nth-child(7)').children(':first').val().substring(1, itembody.children(':nth-child(7)').children(':first').val().length).replaceAll(",", "");
                errorMessage = checkError1(service['price'], itembody.children(':nth-child(7)').children(':first')) || errorMessage;
                services.push(service);
            }
        }
        sendData['services'] = services;
        var employees = [];
        if($('#employeeGroup').length)
        {
            
            var employeeDiv = $('#employeeGroup > .table > tbody');
            for(var i = 0; i < employeeDiv.children().length - 1; i += 2)
            {
                var itembody = employeeDiv.children().eq(i);
                var employee = {};
                employee['name'] = itembody.children(':nth-child(3)').children(':nth-child(2)').children(':first').val();
                errorMessage = checkError(employee['name'], itembody.children(':nth-child(3)').children(':nth-child(2)').children(':first')) || errorMessage;
                employee['hours'] = itembody.children(':nth-child(4)').children(':first').val();
                errorMessage = checkError1(employee['hours'], itembody.children(':nth-child(4)').children(':first')) || errorMessage;
                employee['cost'] = itembody.children(':nth-child(5)').children(':first').val().substring(1, itembody.children(':nth-child(5)').children(':first').val().length).replaceAll(",", "");
                errorMessage = checkError1(employee['cost'], itembody.children(':nth-child(5)').children(':first')) || errorMessage;
                employee['total'] = itembody.children(':nth-child(6)').children(':first').val().substring(1, itembody.children(':nth-child(6)').children(':first').val().length).replaceAll(",", "");
                errorMessage = checkError1(employee['total'], itembody.children(':nth-child(6)').children(':first')) || errorMessage;
                employees.push(employee);
            }
        }
        sendData['employees'] = employees;
    }
    $("body").on("click",".btnSave",function(e){
        e.preventDefault();
        getSendData();
        if(!errorMessage)
        {
            $.ajax({
                data: sendData,
                url: routeUrl,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    isChanged = false;
                    $('.btnSave').text('Save');
                    $('#quoteid').val(data['quoteId']);
                    M.toast({
                        html: qIType + ' saved successfully!',
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
        }
        else
        {
            Swal.fire({
                title: "{{ __('messages.Warning') }}",
                text: "{{ __('messages.You must input correct values for all fields in the table.') }}",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ok',
            });
        }
        
    });
    $('body').on('change', '.serviceName', function() {
        var itembody = $(this).parent().parent().parent();
        for(var i = 0; i < cservicesDatas.length; i ++)
            if(cservicesDatas[i].name == $(this).val())
            {
                itembody.children(':nth-child(4)').children(':first').val(cservicesDatas[i].provider);
                itembody.children(':nth-child(5)').children(':first').val(cservicesDatas[i].cost).change();
                itembody.children(':nth-child(6)').children(':first').val(cservicesDatas[i].utility).change();
                itembody.children(':nth-child(7)').children(':first').val(cservicesDatas[i].price).change();
                break;  
            }
    });

    $('body').on('change', '.employeeName', function() {
        var itembody = $(this).parent().parent().parent();
        for(var i = 0; i < employeesData.length; i ++)
        {
            if(employeesData[i].name == $(this).val())
            {
                var itembody = $(this).parent().parent().parent();
                if(employeesData[i].cycle == 'Weekly')
                    itembody.children(':nth-child(5)').children(':first').val(employeesData[i].salary / 56).change();
                else if(employeesData[i].cycle == 'Monthly')
                    itembody.children(':nth-child(5)').children(':first').val(employeesData[i].salary / 252).change();
                else
                    itembody.children(':nth-child(5)').children(':first').val(employeesData[i].salary).change();
                break;  
            }
        }
    });

    function checkError(value, ele)
    {
        if(value == '' || value == null)
        {
            ele.addClass('invalid-error');
            return true;
        }
        ele.removeClass('invalid-error');
        return false;
    }
    function checkError1(value, ele)
    {
        if(value == '' || value == null || !$.isNumeric(value))
        {
            ele.addClass('invalid-error');
            return true;
        }
        ele.removeClass('invalid-error');
        return false;
    }

    //total
    $('body').on('change', '#discountCheck', function() {
        if($('#discountCheck').prop("checked") == true)
        {
            $('#discountInput').prop("disabled", false);
        }
        else{
            $('#discountInput').prop("disabled", true);
        }
        getTotalSum();
    });
    $('body').on('change', '#unpreventedCheck', function() {
        if($('#unpreventedCheck').prop("checked") == true)
        {
            $('#unpreventedInput').prop("disabled", false);
        }
        else{
            $('#unpreventedInput').prop("disabled", true);
        }
        getTotalSum();
    });
    $('body').on('change', '#shopdaysCheck', function() {
        if($('#shopdaysCheck').prop("checked") == true)
        {
            $('#shopdaysInput').prop("disabled", false);
        }
        else{
            $('#shopdaysInput').prop("disabled", true);
        }
        getTotalSum();
    });
    $('body').on('change', '#advanceCheck', function() {
        if($('#advanceCheck').prop("checked") == true)
        {
            $('#advanceInput').prop("disabled", false);
        }
        else{
            $('#advanceInput').prop("disabled", true);
        }
        getAdvance();
    });

    

    $('body').on('keypress', 'input[inputmode="numeric"]', function(e) {
        if (!String.fromCharCode(e.which).match(/[0-9.]/)) return false;
    });
    $('body').on('change', '#advanceInput', function() {
        var val = $(this).val();
        val = parseFloat(val);

        if(val > 100)
            val = 100;

        $(this).val(z(val) + '%');
        
        getAdvance();
    });
    $('body').on('change', '#discountInput', function() {
        var val = $(this).val();
        val = parseFloat(val);

        if(val > 100)
            val = 100;

        $(this).val(z(val) + '%');
        
        getTotalSum();
    });
    $('body').on('change', '#unpreventedInput', function() {
        var val = $(this).val();
        val = parseFloat(val);

        if(val > 100)
            val = 100;

        $(this).val(z(val) + '%');
        getTotalSum();
    });
    $('body').on('change', '#shopdaysInput', function() {
        f($(this));
        getTotalSum();
    });

    function getAdvance()
    {
        if($('#advanceCheck').prop("checked") == true)
        {
            var val = $('#advanceInput').val().substring(0, $('#advanceInput').val().length - 1).replaceAll(',', '');
            val = parseFloat(val);
            var advance = Total * val / 100;
            $('#sumAdvance').text(z1(advance.toFixed(2), '$'));
            $('#previewAdvance').text(z1(advance.toFixed(2), '$'));
        }
    }

    function getTotalSum()
    {
        //items
        var discountTotal = 0;
        shopdaysTotal = 0;
        unpreventedTotal = 0;
        itemTotal = 0;
        servicesTotal = 0;
        employeesTotal = 0;
        $('.itemTotal').each(function(){
            var val = $(this).val().substring(1, $(this).val().length).replaceAll(',', '');
            val = parseFloat(val);
            if($.isNumeric(val))
            {
                itemTotal = itemTotal + val;
            }
        });
        $('#sumItems').text(z1(itemTotal.toFixed(2), '$'));

        //shopDays
        if($('#shopdaysCheck').prop("checked") == true)
        {
            shopdaysTotal = $('#shopdaysInput').val().replaceAll(',', '') * fixedTotal;
            shopdaysTotal = parseFloat(shopdaysTotal);
            $('#sumShopdays').text(z1(shopdaysTotal.toFixed(2), '$'));
        }
        else
        {
            $('#sumShopdays').text('$0.00');
        }
        
        //services
        $('.serviceTotal').each(function(){
            var val = $(this).val().substring(1, $(this).val().length).replaceAll(',', '');
            val = parseFloat(val);
            if($.isNumeric(val))
            {
                servicesTotal = servicesTotal + val;
            }
        });
        $('#sumServices').text(z1(servicesTotal.toFixed(2), '$'));

        //employees
        $('.employeeTotal').each(function(){
            var val = $(this).val().substring(1, $(this).val().length).replaceAll(',', '');
            val = parseFloat(val);
            if($.isNumeric(val))
            {
                employeesTotal = employeesTotal + val;
            }
        });
        $('#sumEmployees').text(z1(employeesTotal.toFixed(2), '$'));

        //subTotal
        subTotal = parseFloat(itemTotal) + parseFloat(shopdaysTotal) + parseFloat(servicesTotal) + parseFloat(employeesTotal);
        $('#sumSubtotal').text(z1(subTotal.toFixed(2), '$'));
        $('#previewSubtotal').text(z1(subTotal.toFixed(2), '$'));

        //unprevented
        if($('#unpreventedCheck').prop("checked") == true)
        {
            var val = $('#unpreventedInput').val().substring(0, $('#unpreventedInput').val().length - 1).replaceAll(',', '');
            val = parseFloat(val);

            unpreventedTotal = subTotal * val / 100;
            $('#sumUnprevented').text(z1(unpreventedTotal.toFixed(2), '$'));
        }
        else
        {
            $('#sumUnprevented').text('$0.00');
        }

        //discount
        if($('#discountCheck').prop("checked") == true)
        {
            var val = $('#discountInput').val().substring(0, $('#discountInput').val().length - 1).replaceAll(',', '');
            val = parseFloat(val);

            discountTotal = subTotal * val / 100;
            $('#sumDiscount').text('-' + z1(discountTotal.toFixed(2), '$'));
            $('#previewDiscount').text('-' + z1(discountTotal.toFixed(2), '$'));
        }
        else
        {
            $('#sumDiscount').text('-$0.00');
            $('#previewDiscount').text('-$0.00');
        }

        //total
        Total = subTotal + unpreventedTotal - discountTotal;
        $('#sumTotal').text(z1(Total.toFixed(2), '$'));
        $('#previewTotal').text(z1(Total.toFixed(2), '$'));
    }

    $('body').on('click', '#previewBtn', function() {
        getSendData();
        if(errorMessage)
        {
            Swal.fire({
                title: "{{ __('messages.Warning') }}",
                text: "{{ __('messages.You must input correct values for all fields in the table.') }}",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ok',
            });
            return;
        }
        $('#editQuoteDiv').hide();
        $('#previewQuoteDiv').show();
        if(sendData['quoteNumber'] != '' && sendData['quoteNumber'] != null && qIType=="Quote")
            $('#preQuoteNumber').text("{{ __('messages.Quote') }}" + ' No. ' + sendData['quoteNumber']);
        if(sendData['quoteNumber'] != '' && sendData['quoteNumber'] != null && qIType=="Invoice")
            $('#preQuoteNumber').text("{{ __('messages.Invoice') }}" + ' No. ' + sendData['quoteNumber']);
        if(sendData['client'] != '' && sendData['client'] != null)
            $('#preClient').text('Att: ' + sendData['client']);
        if(sendData['phone'] != '' && sendData['phone'] != "(   )    -    " && sendData['phone'] != null)
            $('#prePhone').text("{{ __('messages.Phone') }}" + ': +' + sendData['countryCode'] + ' ' + sendData['phone']);
        if(sendData['email'] != '' && sendData['email'] != null)
            $('#preEmail').text("{{ __('messages.Mail') }}" + ': ' + sendData['email']);
        if(sendData['addline'] != '' && sendData['addline'] != null)
            $('#preAddress').text(sendData['addline']);
        if(sendData['project'] != '' && sendData['project'] != null)
            $('#preProject').text(sendData['project']);
        if(sendData['companyname'] != '' && sendData['companyname'] != null)
            $('#preCompany').text(sendData['companyname']);
        if($('#discountCheck').prop("checked") == true)
        {
            $('#discountRow').show();
            if($('#discountInput').val() == '0%')
                $('#discountRow').hide();
            else
                $('#preDiscountHeader').text("{{ __('messages.Discount') }}" + +' ' + z($('#discountInput').val()))
        }
        else
            $('#discountRow').hide();

        if($('#advanceCheck').prop("checked") == true)
        {
            $('#advanceRow').show();
            if($('#advanceInput').val() == '0%')
                $('#advanceRow').hide();
            else
                $('#preAdvanceHeader').text("{{ __('messages.Advance') }}" + ' ' + z($('#advanceInput').val()))
        }
        else
        {
            $('#advanceRow').hide();
        }
        setPreviewTable();
    });
    
    // $('body').on('click', '#searchAddInput', function() {
    //     console.log($('.autocomplete-content'));
    //     console.log($('.autocomplete-content > li'));
    //     console.log("asdf");
    // });

    $('body').on('click', '#editQuoteBtn', function() {
        $('#editQuoteDiv').show();
        $('#previewQuoteDiv').hide();
    });

    $('body').on('click', '#printBtn', function() {
        window.print();
    });

    function setPreviewTable()
    {
        itemCount = 0;
        var isMaterial = false;
        var groups = sendData['groups'];
        $('#preMain').empty();
        
        
        for (var i = 0; i < groups.length; i ++)
        {
            itemCount = itemCount + groups[i]['items'].length;
        }

        for (var i = 0; i < groups.length; i ++)
        {
            $('#preMain').append('<span class="big-font bold-weight-font">'+groups[i]['name']+'</span>');
            $('#preMain').append('<table class="groupTable striped">\
                                <thead>\
                                <tr><th style="width:15%;">'+ "{{ __('messages.Quantity') }}" + '</th><th style="width:55%; text-align: left">'+ "{{ __('messages.Description') }}" + '</th><th class="totalField" style="width:15%;">'+ "{{ __('messages.Unit Price') }}" + '</th><th class="totalField" style="width:15%; text-align: right">Total</th></tr>\
                                </thead>\
                                <tbody></tbody>\
                                </table>');
            var tbody = $('#preMain').children(':last').children(':nth-child(2)');
            for (var j = 0; j < groups[i]['items'].length; j ++)
            {
                tbody.append('<tr class="previewItemRow"><td></td><td style="text-align: left;"></td><td class="totalField" style="text-align: right;"></td><td class="totalField" style="text-align: right;"></td></tr>');
                // var total = parseFloat(groups[i]['items'][j]['total']);
                // var utility = parseFloat(groups[i]['items'][j]['utility']);
                // var quantity = parseFloat(groups[i]['items'][j]['quantity']);
                // total = parseFloat(total + (servicesTotal + employeesTotal + shopdaysTotal + unpreventedTotal) / itemCount);
                // var cost = parseFloat(total * (100 - utility) / 100 / quantity);
                // cost = cost.toFixed(2);
                // total = total.toFixed(2);
                tbody.children(':last').children(':first').text(groups[i]['items'][j]['quantity']);
                tbody.children(':last').children(':nth-child(2)').text(groups[i]['items'][j]['name']);
                tbody.children(':last').children(':nth-child(3)').text(z1(groups[i]['items'][j]['cost'], '$'));
                tbody.children(':last').children(':nth-child(4)').text(z1(groups[i]['items'][j]['total'], '$'));
                
                if(groups[i]['items'][j]['materials'].length)
                {
                    isMaterial = true;
                }
            }
        }
        
        var itotal = itemTotal + employeesTotal + servicesTotal + shopdaysTotal + unpreventedTotal;
        itotal = itotal.toFixed(2);
        var subTo = subTotal + unpreventedTotal;
        subTo = subTo.toFixed(2);
        $('#previewSubtotal').text(z1(subTo, '$'));

        var services = sendData['services'];
        if(services.length)
        {
            $('#preMain').append('<span class="big-font bold-weight-font" id="preServicesHeader" style="display:none;">External Services</h5>');
            $('#preMain').append('<table class="groupTable striped" id="preServicesBody" style="display:none;">\
                                <thead>\
                                <tr><th style="text-align: left;width: 80%;">'+ "{{ __('messages.Description') }}" + '</th><th class="totalField" style="text-align: right;">Total</th></tr>\
                                </thead>\
                                <tbody></tbody>\
                                </table>');
            var tbody = $('#preMain').children(":last").children(':nth-child(2)');
            for (var j = 0; j < services.length; j ++)
            {
                tbody.append('<tr><td style="text-align: left;"></td><td class="totalField" style="text-align: right;"></td></tr>');
                tbody.children(':last').children(':first').text(services[j]['name']);
                tbody.children(':last').children(':nth-child(2)').text(z1(services[j]['price'], '$'));
            }
        }

        var employees = sendData['employees'];
        if(employees.length)
        {
            $('#preMain').append('<table class="groupTable striped" id="preEmployeesBody" style="display:none;">\
                                <tbody></tbody>\
                                </table>');
            var tbody = $('#preMain').children(':last').children(':first');
            for (var j = 0; j < employees.length; j ++)
            {
                tbody.append('<tr><td style="text-align: left;width: 80%;"></td><td class="totalField" style="text-align: right;"></td></tr>');
                tbody.children(':last').children(':first').text(employees[j]['name']);
                tbody.children(':last').children(':nth-child(2)').text(z1(employees[j]['total'], '$'));
            }
        }
        if(isMaterial)
        {
            $('#preMain').append('<span class="big-font bold-weight-font" id="materialTableHeader" style="display:none;">List of Materials</span>');
                $('#preMain').append('<table class="groupTable striped" id="materialTable" style="display:none;">\
                                    <thead>\
                                    <tr><th style="text-align: left; width: 80%;">'+ "{{ __('messages.Description') }}" + '</th><th class="totalField" style="text-align: right;">'+ "{{ __('messages.Quantity') }}" + '</th></tr>\
                                    </thead>\
                                    <tbody></tbody>\
                                    </table>');
            for (var i = 0; i < groups.length; i ++)
            {
                
                var tbody = $('#preMain').children(':last').children(':nth-child(2)');
                for (var j = 0; j < groups[i]['items'].length; j ++)
                {
                    if(groups[i]['items'][j]['materials'].length)
                    {
                        for (var k = 0; k < groups[i]['items'][j]['materials'].length; k ++)
                        {
                            tbody.append('<tr><td style="text-align: left;"></td><td class="totalField" style="text-align: right;"></td></tr>');
                            tbody.children(':last').children(':first').text(groups[i]['items'][j]['materials'][k]['description']);
                            tbody.children(':last').children(':nth-child(2)').text(z(groups[i]['items'][j]['materials'][k]['quantity']));
                        }
                    }
                }
            }
        }

        $('#checkPreMaterials').change();
        $('#checkPreTotal').change();
        $('#checkPreServices').change();
        $('#checkPreEmployees').change();

        $('#totalText').text(convert(Total.toFixed(2)));
    }

    //preview check

    $('body').on('change', '#checkPreMaterials', function() {
        if($('#checkPreMaterials').prop("checked") == true)
        {
            $('#materialTableHeader').show();
            $('#materialTable').show();
        }
        else{
            $('#materialTableHeader').hide();
            $('#materialTable').hide();
        }
    });

    $('body').on('change', '#checkPreTotal', function() {
        if($('#checkPreTotal').prop("checked") == true)
        {
            $('.totalField').each(function(){
                $(this).hide();
            });
        }
        else{
            $('.totalField').each(function(){
                $(this).show();
            });
        }
    });

    $('body').on('change', '#checkPreServices', function() {
        if($('#checkPreServices').prop("checked") == true)
        {
            $('#preServicesBody').show();
            $('#preServicesHeader').show();
            $('.preServicesTotal').show();
            $('.previewItemRow').each(function(){
                var total = parseFloat($(this).children(':nth-child(4)').text().substring(1, $(this).children(':nth-child(4)').text().length).replaceAll(',', ''));
                var quantity = parseFloat($(this).children(':first').text().replaceAll(',', ''));
                total = parseFloat(total - servicesTotal / itemCount);
                var cost = parseFloat(total / quantity);
                cost = cost.toFixed(2);
                total = total.toFixed(2);
                $(this).children(':nth-child(3)').text(z1(cost, '$'));    
                $(this).children(':nth-child(4)').text(z1(total, '$'));
            });    
        }
        else{
            $('#preServicesBody').hide();
            $('#preServicesHeader').hide();
            $('.preServicesTotal').hide();
            $('.previewItemRow').each(function(){
                var total = parseFloat($(this).children(':nth-child(4)').text().substring(1, $(this).children(':nth-child(4)').text().length).replaceAll(',', ''));
                var quantity = parseFloat($(this).children(':first').text().replaceAll(',', ''));
                total = parseFloat(total + servicesTotal / itemCount);
                var cost = parseFloat(total / quantity);
                cost = cost.toFixed(2);
                total = total.toFixed(2);
                $(this).children(':nth-child(3)').text(z1(cost, '$'));    
                $(this).children(':nth-child(4)').text(z1(total, '$'));
            });    
        }
    });
    
    $('body').on('change', '#employeeAddInput', function() {
        if ($('#employeeAddInput').val() != null && $('#employeeAddInput').val() != "Select Employee")
        {
            addNew($(this).parent().parent().parent());
        }
    });

    $('body').on('change', 'input', function() {
        var id = $(this).attr('id');

        if(id != "checkPreMaterials" && id != "checkPreServices" && id != "checkPreEmployees" && id != "checkPreTotal" && !$(this).hasClass('modalInput'))
            isChanged = true;
    });

    $('body').on('click', '.es-list li', function() {
        isChanged = true;
    });

    $('body').on('keypress', '.quoteInfoInput', function() {
        var id = $(this).attr('id');
        $('#error' + id).empty();
    });

    $('body').on('change', '#checkPreEmployees', function() {
        if($('#checkPreEmployees').prop("checked") == true)
        {
            $('#preEmployeesBody').show();
            $('#preEmployeesHeader').show();
            $('.preEmployeesTotal').show();
            $('.previewItemRow').each(function(){
                var total = parseFloat($(this).children(':nth-child(4)').text().substring(1, $(this).children(':nth-child(4)').text().length).replaceAll(',', ''));
                var quantity = parseFloat($(this).children(':first').text().replaceAll(',', ''));
                total = parseFloat(total - employeesTotal / itemCount);
                var cost = parseFloat(total / quantity);
                cost = cost.toFixed(2);
                total = total.toFixed(2);
                $(this).children(':nth-child(3)').text(z1(cost, '$'));    
                $(this).children(':nth-child(4)').text(z1(total, '$'));
            });    
        }
        else{
            $('#preEmployeesBody').hide();
            $('#preEmployeesHeader').hide();
            $('.preEmployeesTotal').hide();
            $('.previewItemRow').each(function(){
                var total = parseFloat($(this).children(':nth-child(4)').text().substring(1, $(this).children(':nth-child(4)').text().length).replaceAll(',', ''));
                var quantity = parseFloat($(this).children(':first').text().replaceAll(',', ''));
                total = parseFloat(total + employeesTotal / itemCount);
                var cost = parseFloat(total / quantity);
                cost = cost.toFixed(2);
                total = total.toFixed(2);
                $(this).children(':nth-child(3)').text(z1(cost, '$'));    
                $(this).children(':nth-child(4)').text(z1(total, '$'));
            });    
        }
    });


    $('#sendByWhatsapp').click(function (e) {
        e.preventDefault();
        $('.quoteId').val($('#quoteid').val());
        if($('#quoteid').val() == null || $('#quoteid').val() == '' || $('#quoteid').val() < 0)
        {
            Swal.fire({
                title: "{{ __('messages.Warning') }}",
                text: "{{ __('messages.You have to create first.') }}",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ok',
            });
            return;
        }
        if(isChanged)
        {
            Swal.fire({
                title: "{{ __('messages.Warning') }}",
                text: "{{ __('messages.You have to save first.') }}",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ok',
            });
            return;
        }
        $('.showMaterial').val(Number($('#checkPreMaterials').prop("checked")));
        $('.showService').val(Number($('#checkPreServices').prop("checked")));
        $('.showEmployee').val(Number($('#checkPreEmployees').prop("checked")));
        $('.showOnlyTotal').val(Number($('#checkPreTotal').prop("checked")));
        $('.messageContent').val($('.print-area').html());
        var phone = $('#phone').val().replace(/[^0-9]/g,'');
        $('#whatsappForm').trigger("reset");
        $('#whatsappModal').modal()[0].M_Modal.options.dismissible = false;
        $('#whatsappModal').modal('open');
        $('#whatsappnumber').val(phone);
        $('#whatsappnumber').focus();
    });

    $('#sendByMail').click(function (e) {
        e.preventDefault();
        $('.quoteId').val($('#quoteid').val());
        if($('#quoteid').val() == null || $('#quoteid').val() == '' || $('#quoteid').val() < 0)
        {
            Swal.fire({
                title: "{{ __('messages.Warning') }}",
                text: "{{ __('messages.You have to create first.') }}",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ok',
            });
            return;
        }
        if(isChanged)
        {
            Swal.fire({
                title: "{{ __('messages.Warning') }}",
                text: "{{ __('messages.You have to save first.') }}",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ok',
            });
            return;
        }
        $('.showMaterial').val(Number($('#checkPreMaterials').prop("checked")));
        $('.showService').val(Number($('#checkPreServices').prop("checked")));
        $('.showEmployee').val(Number($('#checkPreEmployees').prop("checked")));
        $('.showOnlyTotal').val(Number($('#checkPreTotal').prop("checked")));
        $('.messageContent').val($('.print-area').html());
        $('#mailForm').trigger("reset");
        $('#mailModal').modal()[0].M_Modal.options.dismissible = false;
        $('#mailModal').modal('open');
        $('#from').val('{!! Auth::user()->name !!}');
        $('#to').val($('#email').val());
        $('#subject').val($('#project').val());
        $('#from').focus();
        $('#to').focus();
        $('#subject').focus();
    });

    $('#cancelMailBtn').click(function (e) {
        e.preventDefault();
        $(".error").html('');
        $('#mailModal').modal('close');
   });

   $('#cancelWhatsappBtn').click(function (e) {
        e.preventDefault();
        $(".error").html('');
        $('#whatsappModal').modal('close');
   });
   
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

   $('#sendMailBtn').click(function (e) {
        e.preventDefault();
        
        $.ajax({
            data: $('#mailForm').serialize() + '&type=' + qIType,
            url: "{{ route('user.sendByMail') }}",
            type: "POST",
            dataType: 'json',
            beforeSend: function(){
                $('#sendMailBtn').text('Sending...');
                $('#sendMailBtn').prop('disabled', true);
                $('#cancelMailBtn').prop('disabled', true);
            },
            success: function (data) {
                $(".error").html('');
                $('#mailForm').trigger("reset");
                $('#mailModal').modal('close');
                M.toast({
                    html: data['success'],
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
                $('#sendMailBtn').text('Send');
                $('#sendMailBtn').prop('disabled', false);
                $('#cancelMailBtn').prop('disabled', false);
            },
            complete: function(){
                $('#sendMailBtn').text('Send');
                $('#sendMailBtn').prop('disabled', false);
                $('#cancelMailBtn').prop('disabled', false);
            }
      });
   });

   $("body").on("click",".setEditable",function(){
        var prev = $(this).prev();
        prev.select();
   });

   $('#sendWhatsappBtn').click(function (e) {
        e.preventDefault();
        var d = new Date();
        var passhash = CryptoJS.MD5($('#quoteid').val() + d.getTime()).toString();
        var ua = navigator.userAgent.toLowerCase();
        var isMobile = ua.indexOf("mobile") > -1;

        if (isMobile) {

            window.location.href = "whatsapp://send?text=%20" + 'To see the quote, visit here:%0a' + encodeURIComponent(window.location.origin + '/public_quote/' + passhash) + "&phone=52"+ $('#whatsappnumber').val();
        } else {

            window.open("https://web.whatsapp.com/send?text=%20" + 'To see the quote, visit here:%0a' + encodeURIComponent(window.location.origin + '/public_quote/' + passhash) + "&phone=52"+ $('#whatsappnumber').val());
        }
        $.ajax({
            data: $('#whatsappForm').serialize() + '&type=' + qIType + '&urlName=' + passhash + '&isSend=1',
            url: "{{ route('user.sendByWhatsapp') }}",
            type: "POST",
            dataType: 'json',
            beforeSend: function(){
                $('#sendWhatsappBtn').text('Sending...');
                $('#sendWhatsappBtn').prop('disabled', true);
                $('#cancelWhatsappBtn').prop('disabled', true);
            },
            success: function (data) {
                $(".error").html('');
                $('#whatsappForm').trigger("reset");
                $('#whatsappModal').modal('close');
                M.toast({
                    html: data['success'],
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
                $('#sendWhatsappBtn').text('Ok');
                $('#sendWhatsappBtn').prop('disabled', false);
                $('#cancelWhatsappBtn').prop('disabled', false);
            },
            complete: function(){
                $('#sendWhatsappBtn').text('Ok');
                $('#sendWhatsappBtn').prop('disabled', false);
                $('#cancelWhatsappBtn').prop('disabled', false);
            }
      });
   });

    $('#sendForm').validate({
    rules: {
      client: {
        required: true,
      },
      companyname: {
        required: true,
      },
      phone: {
        required: true,
      },
      project: {
        required: true,
      },
    },
    messages: {
        client: {
        required: "Invalid client name",
      },
      companyname: {
        required: "Invalid company name",
      },
      phone: {
        required: "Invalid phone number",
      },
      project: {
        required: "Invalid project name",
      },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
    function Padder(len, pad) {
        if (len === undefined) {
            len = 1;
        } else if (pad === undefined) {
            pad = '0';
        }

        var pads = '';
        while (pads.length < len) {
            pads += pad;
        }

        this.pad = function (what) {
            var s = what.toString();
            return pads.substring(0, pads.length - s.length) + s;
        };
    }
    function addGroup()
    {
        var id = newId(), randomCol = themes[Math.floor(Math.random() * themes.length)];
        $("#fGroups").append('<div class="fGroup ftt'+randomCol+'">\
            <table class="table ftGroup">\
                <thead>\
                <th class="ftGSelector">\
            <a class="dropdown-trigger btn dropdown-btn" href="#" data-target="dropdown'+id+'" id="dropbtn'+id+'"><i class="material-icons">arrow_drop_down</i></a>\
                    <ul class="dropdown-content" id="dropdown'+id+'" tabindex="0" style>\
                    <li><a href="#" class="ftCollapse">'+ "{{ __('messages.Expand') }}" +'</a></li>\
                    <li><a href="#" class="ftDelete">'+ "{{ __('messages.Delete') }}" +'</a></li>\
                    <li><a href="#" class="addNewGroup">'+ "{{ __('messages.Add') }}" + ' '+ "{{ __('messages.New') }}" + ' '+ "{{ __('messages.Group') }}" +'</a></li> \
                    <li><a href="#" class="addService">'+ "{{ __('messages.Add') }}" + ' '+ "{{ __('messages.Service') }}" +'</a></li> \
                    <li><a href="#" class="addEmployee">'+ "{{ __('messages.Add') }}" + ' '+ "{{ __('messages.Employee') }}" +'</a></li> \
                    <li class="divider" tabindex="-1"></li>\
                    <li><a href="#" class="fttBlue">'+ "{{ __('messages.Blue') }}" + ' '+ "{{ __('messages.Theme') }}" +'</a></li>\
                    <li><a href="#" class="fttPurple">'+ "{{ __('messages.Purple') }}" + ' '+ "{{ __('messages.Theme') }}" +'</a></li>\
                    <li><a href="#" class="fttRed">'+ "{{ __('messages.Pink') }}" + ' '+ "{{ __('messages.Theme') }}" +'</a></li>\
                    <li><a href="#" class="fttGreen">'+ "{{ __('messages.Green') }}" + ' '+ "{{ __('messages.Theme') }}" +'</a></li>\
                    <li><a href="#" class="fttOrange">'+ "{{ __('messages.Orange') }}" + ' '+ "{{ __('messages.Theme') }}" +'</a></li>\
                    </ul>\
                </th>\
                <th colspan="2">\
                    <div class="display-flex">\
                        <input type="text" class="font1 invisInput ftTitle" value="Concept" placeholder="Concept">\
                        <i class="material-icons setEditable">edit</i> \
                    </div>\
                </th>\
                <th class="font1">'+ "{{ __('messages.Quantity') }}" +'</th>\
                <th class="font1">'+ "{{ __('messages.Cost') }}" +'</th>\
                <th class="font1">'+ "{{ __('messages.Margin') }}" +'</th>\
                <th class="font1">Total</th>\
                </thead>\
                <tbody>\
                <tr class="ftNew">\
                    <td class="ftISelector"><div><img src="'+baseurl+'tri_selector_black.png"></div></td>\
                    <td style="width:0px !important;"></td>\
                    <td class="ftField">\
                    <input type="text" class="font1 invisInput" placeholder="+ {{ __('messages.Add') }}">\
                    </td>\
                    <td></td><td></td><td></td>\
                    <td>\
                    <div class="ftNewBtn">+</div>\
                    </td>\
                </tr>\
                </tbody>\
            </table>\
            </div>');
        setDraggable();
        $(".dropdown-trigger").dropdown();
    }
    function addService() 
    {
        if(!$('#serviceGroup').length)
        {
            var randomCol = themes[Math.floor(Math.random() * themes.length)], id = newId();
            var eleStr = '<div class="fGroup fttGreen" id="serviceGroup">\
            <table class="table ftGroup">\
            <thead>\
                <th class="ftGSelector">\
                <a class="dropdown-trigger btn dropdown-btn" href="#" data-target="dropdown'+id+'" id="dropbtn'+id+'"><i class="material-icons">arrow_drop_down</i></a>\
                <ul class="dropdown-content" id="dropdown'+id+'" tabindex="0" style>\
                    <li><a href="#" class="ftDelete">'+ "{{ __('messages.Delete') }}" +'</a></li>\
                </ul>\
                </th>\
                <th colspan="2">\
                <input type="text" class="font1 invisInput ftTitle" value="External Services" placeholder="Concept" readonly>\
                </th>\
                <th class="font1">'+ "{{ __('messages.Provider') }}" +'</th>\
                <th class="font1">'+ "{{ __('messages.Cost') }}" +'</th>\
                <th class="font1">'+ "{{ __('messages.Margin') }}" +'</th>\
                <th class="font1">'+ "{{ __('messages.Price') }}" +'</th>\
            </thead>\
            <tbody>\
                <tr class="ftNew">\
                <td class="ftISelector"><div><img src="'+baseurl+'tri_selector_black.png"></div></td>\
                <td style="width:0px !important;"></td>\
                <td class="ftField">\
                <div class="input-field">\
                    <input type="text" class="font1 invisInput autocomplete" autocomplete="off" id="searchAddInput" placeholder="+ {{ __('messages.Add') }}">\
                    </div>\
                </td>\
                <td></td><td></td><td></td>\
                <td>\
                    <div class="ftNewBtn">+</div>\
                </td>\
                </tr>\
            </tbody>\
            </table>\
        </div>';
            if(!$('#employeeGroup').length)
                $("#fMain").append($(eleStr));
            else
            {
                $("#employeeGroup").before($(eleStr));
            }
            setDraggable();
            $(".dropdown-trigger").dropdown();
            $('#searchAddInput').autocomplete({
                data: cservicesData,
                limit: 5,
                onAutocomplete: function(){
                    addNew($('#searchAddInput').parent().parent().parent());
                }
            });
        }
    }

    function addEmployee() 
    {
        if(!$('#employeeGroup').length)
        {
            var randomCol = themes[Math.floor(Math.random() * themes.length)], id = newId();
            $("#fMain").append($('<div class="fGroup fttPurple" id="employeeGroup">\
                <table class="table ftGroup">\
                    <thead>\
                    <th class="ftGSelector">\
                        <a class="dropdown-trigger btn dropdown-btn" href="#" data-target="dropdown'+id+'" id="dropbtn'+id+'"><i class="material-icons">arrow_drop_down</i></a>\
                        <ul class="dropdown-content" id="dropdown'+id+'" tabindex="0" style>\
                        <li><a href="#" class="ftDelete">'+ "{{ __('messages.Delete') }}" +'</a></li>\
                        </ul>\
                    </th>\
                    <th colspan="2">\
                        <input type="text" class="font1 invisInput ftTitle" value="Employees" readonly>\
                    </th>\
                    <th class="font1">'+ "{{ __('messages.Hours') }}" +'</th>\
                    <th class="font1">'+ "{{ __('messages.Cost') }}" +'</th>\
                    <th class="font1">Total</th>\
                    </thead>\
                    <tbody>\
                    <tr class="ftNew">\
                        <td class="ftISelector"><div><img src="'+baseurl+'tri_selector_black.png"></div></td>\
                        <td style="width:0px !important;"></td>\
                        <td class="ftField">\
                        <div class="input-field">\
                            <select class="select2 invisInput browser-default" id="employeeAddInput" style="width:100%;">\
                            <option value="Select Employee" disabled selected>Select Employee</option>\
                            </select>\
                        </div>\
                        </td>\
                        <td></td><td></td>\
                        <td>\
                        <div class="ftNewBtn">+</div>\
                        </td>\
                    </tr>\
                    </tbody>\
                </table>\
                </div>'));
            setDraggable();
            $(".dropdown-trigger").dropdown();
            $("#employeeAddInput").select2({
                dropdownAutoWidth: true,
                width: '100%',
        });
        for(employee of employeesData)
            {
                $("#employeeAddInput").append(new Option(employee.name, employee.name));
            }
            $('#employeeAddInput').val($("#employeeAddInput option:first").val()).change();
        }
    }
    // Adding Items
    function addNew(TR, forceAdd = false) {
        
        var tBody = TR.parent();
        if(tBody.parent().parent().parent().attr('id') == 'fMain')
            iName = TR.children(".ftField").children().first().children().first();
        else
            iName = TR.children(".ftField").children().first();

        if (forceAdd || (iName.val() != "" && iName.val() != null && iName.val() != "Select Employee")) {
            var index = tBody.children().length - 1,
                id = newId(),
                fadeStatus = 'style="display: none;"';
                colStatus = 'Expand';
                if(tBody.parent().parent().parent().attr('id') == "fGroups")
                {
                    tBody.insertAt(index, '<tr style="display: none;">\
                    <td class="ftISelector">\
                    <a class="dropdown-trigger btn indigo dropdown-btn" href="#" data-target="dropdownchild'+id+'" id="dropbtn'+id+'"><i class="material-icons">arrow_drop_down</i></a>\
                    <ul class="dropdown-content" id="dropdownchild'+id+'" tabindex="0" style>\
                        <li style="display:none;"><a href="#" class="ftCollapse">'+colStatus + "{{ __('messages.Expand') }}" + '</a></li>\
                        <li><a href="#" class="ftAddSIRemote">'+ "{{ __('messages.Add') }}" + ' ' + "{{ __('messages.Materials') }}" +'</a></li>\
                        <li><a href="#" class="ftDelete">'+ "{{ __('messages.Delete') }}" +'</a></li>\
                    </ul>\
                    </td>\
                    <td  style="width:0px !important;"></td>\
                    <td>\
                    <img src="'+baseurl+'fav_positive.svg" class="ftOFIcon">\
                    <input type="text" class="font1 invisInput" value="'+iName.val()+'">\
                    </td>\
                    <td>\
                    <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Quantity" value="1">\
                    </td>\
                    <td>\
                    <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Cost" value="$0">\
                    </td>\
                    <td>\
                    <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Utility" value="0.00%">\
                    </td>\
                    <td>\
                    <input type="text" inputmode="numeric" class="font1 invisInput itemTotal" placeholder="Total" value="$0.00">\
                    </td>\
                </tr>');
                    tBody.insertAt(index + 1, '<tr class="ftSubitems"'+fadeStatus+'>\
                    <td colspan="7">\
                    <div class="ftSIDiv">\
                        <table class="table ftSITable">\
                        <thead>\
                            <tr>\
                                <th></th>\
                            <th class="font1">'+ "{{ __('messages.Material') }}" +'</th>\
                            <th class="font1">'+ "{{ __('messages.Provider') }}" +'</th>\
                            <th class="font1">'+ "{{ __('messages.Quantity') }}" +'</th>\
                            <th class="font1">'+ "{{ __('messages.Cost') }}" +'</th>\
                            <th class="font1">Total</th>\
                            </tr>\
                        </thead>\
                        <tbody>\
                        </tbody>\
                        </table>\
                    </div>\
                    </td>\
                </tr>');
                }
                else if(tBody.parent().parent().attr('id') == "serviceGroup"){
                    
                    tBody.insertAt(index, '<tr style="display: none;">\
                        <td class="ftISelector">\
                        <a class="dropdown-trigger btn indigo dropdown-btn" href="#" data-target="dropdownchild'+id+'" id="dropbtn'+id+'"><i class="material-icons">arrow_drop_down</i></a>\
                        <ul class="dropdown-content" id="dropdownchild'+id+'" tabindex="0" style>\
                            <li><a href="#" class="ftDelete">'+ "{{ __('messages.Delete') }}" +'</a></li>\
                        </ul>\
                        </td>\
                        <td  style="width:0px !important;"></td>\
                        <td>\
                        <img src="'+baseurl+'fav_positive.svg" class="ftOFIcon">\
                        <div class="input-field">\
                        <input type="text" class="font1 invisInput autocomplete serviceName" value="'+iName.val()+'" id="serviceName'+id+'" autocomplete="off">\
                        </div>\
                        </td>\
                        <td>\
                        <input type="text" class="font1 invisInput" placeholder="Provider">\
                        </td>\
                        <td>\
                        <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Cost">\
                        </td>\
                        <td>\
                        <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Utility">\
                        </td>\
                        <td>\
                        <input type="text" inputmode="numeric" class="font1 invisInput serviceTotal" placeholder="Total">\
                        </td>\
                    </tr>');
                    tBody.insertAt(index + 1, '<tr class="ftSubitems"'+fadeStatus+'>\
                    <td colspan="7">\
                    <div class="ftSIDiv">\
                        <table class="table ftSITable">\
                        <thead>\
                            <tr>\
                            <th class="font1">'+ "{{ __('messages.Material') }}" +'</th>\
                            <th class="font1">'+ "{{ __('messages.Provider') }}" +'</th>\
                            <th class="font1">'+ "{{ __('messages.Quantity') }}" +'</th>\
                            <th class="font1">'+ "{{ __('messages.Cost') }}" +'</th>\
                            <th class="font1">Total</th>\
                            </tr>\
                        </thead>\
                        <tbody>\
                        </tbody>\
                        </table>\
                    </div>\
                    </td>\
                </tr>');
                for(var i = 0; i < cservicesDatas.length; i ++)
                {
                    if(cservicesDatas[i].name == iName.val())
                    {
                        var itembody = $('#serviceName'+id).parent().parent().parent();
                        itembody.children(':nth-child(4)').children(':first').val(cservicesDatas[i].provider);
                        itembody.children(':nth-child(5)').children(':first').val(cservicesDatas[i].cost).change();
                        itembody.children(':nth-child(6)').children(':first').val(cservicesDatas[i].utility).change();
                        itembody.children(':nth-child(7)').children(':first').val(cservicesDatas[i].price).change();
                        break;  
                    }
                }
                $('#serviceName'+id).autocomplete({
                    data: cservicesData,
                    limit: 5,
                    });
                }
                else{
                    tBody.insertAt(index, '<tr style="display: none;">\
                        <td class="ftISelector">\
                        <a class="dropdown-trigger btn indigo dropdown-btn" href="#" data-target="dropdownchild'+id+'" id="dropbtn'+id+'"><i class="material-icons">arrow_drop_down</i></a>\
                        <ul class="dropdown-content" id="dropdownchild'+id+'" tabindex="0" style>\
                            <li><a href="#" class="ftDelete">'+ "{{ __('messages.Delete') }}" +'</a></li>\
                        </ul>\
                        </td>\
                        <td style="width:0px !important;"></td>\
                        <td>\
                        <img src="'+baseurl+'fav_positive.svg" class="ftOFIcon">\
                        <div class="input-field">\
                        <select class="select2 invisInput browser-default employeeName" style="width:100%;" id="employeeName'+id+'"></select>\
                        </div>\
                        </td>\
                        <td>\
                        <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Hours">\
                        </td>\
                        <td>\
                        <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Cost" readonly>\
                        </td>\
                        <td>\
                        <input type="text" inputmode="numeric" class="font1 invisInput employeeTotal" placeholder="Total" readonly>\
                        </td>\
                    </tr>');
                    tBody.insertAt(index + 1, '<tr class="ftSubitems"'+fadeStatus+'>\
                    <td colspan="7">\
                    <div class="ftSIDiv">\
                        <table class="table ftSITable">\
                        <thead>\
                            <tr>\
                            <th class="font1">'+ "{{ __('messages.Material') }}" +'</th>\
                            <th class="font1">'+ "{{ __('messages.Provider') }}" +'</th>\
                            <th class="font1">'+ "{{ __('messages.Quantity') }}" +'</th>\
                            <th class="font1">Total</th>\
                            </tr>\
                        </thead>\
                        <tbody>\
                        </tbody>\
                        </table>\
                    </div>\
                    </td>\
                </tr>');
                $('#employeeName'+id).select2({
                    dropdownAutoWidth: true,
                    width: '100%',
                    });
                    for(employee of employeesData)
                    {
                        $('#employeeName'+id).append(new Option(employee.name, employee.name));
                    }
                    for(var i = 0; i < employeesData.length; i ++)
                    {
                        if(employeesData[i].name == iName.val())
                        {
                            var itembody = $('#employeeName'+id).parent().parent().parent();
                            var cost = 0;
                            $('#employeeName'+id).val(iName.val()).change();
                            if(employeesData[i].cycle == 'Weekly')
                            {
                                cost = parseFloat(employeesData[i].salary / 56);
                            }
                            else if(employeesData[i].cycle == 'Monthly')
                            {
                                cost = parseFloat(employeesData[i].salary / 252);
                            }
                            else
                            {
                                cost = parseFloat(employeesData[i].salary);
                            }
                            cost = cost.toFixed(2);
                            itembody.children(':nth-child(5)').children(':first').val(cost).change();
                            break;  
                        }
                    }
                    $('#employeeAddInput').val($("#employeeAddInput option:first").val()).change();
                }
                var theNew = tBody.children().eq(index);
                    theNew.fadeOut(1);
                    theNew.fadeIn(500);
                    iName.val('');
                    iName.focus();
                    setDraggable();
                    //scrSizes();
                    $(".dropdown-trigger").dropdown();
            
        } else iName.focus();
    }
    // Menu Listeners
    function addNewSubitem(TRNew, ask, insertId) {
        var tBody = TRNew, field1 = TRNew.children().eq(0).children().first().val();

        var costInput = tBody.parent().parent().parent().parent().parent().children().eq(tBody.parent().parent().parent().parent().parent().children().index(tBody.parent().parent().parent().parent()) - 1).children(':nth-child(5)').children(':first');
        costInput.prop( "readonly", true);

        var expandLi = tBody.parent().parent().parent().parent().parent().children().eq(tBody.parent().parent().parent().parent().parent().children().index(tBody.parent().parent().parent().parent()) - 1).children(':first').children(':nth-child(2)').children(':first');
        expandLi.show();

        if (ask && (field1 == "" || field1 == "+ {{ __('messages.Add') }}")) {
            TRNew.children().eq(0).children().first().focus();
            return false;
        }
    if (!ask) field1 = ""; 
    var newId = newMId();
    var colStatus = 'Expand';
        tBody.insertAt(insertId, '<tr>\
                        <td class="ftMISelector" style="padding-right: 10px !important; border:none !important;">\
                            <a class="dropdown-trigger btn light-blue darken-1 dropdown-btn" href="#" data-target="dropdownMaterial'+newId+'" id="dropMaterial'+newId+'"><i class="material-icons">arrow_drop_down</i></a>\
                            <ul class="dropdown-content" id="dropdownMaterial'+newId+'" tabindex="0" style>\
                            <li><a href="#" class="ftMAddSIRemote">'+ "{{ __('messages.Add') }}" + ' ' + "{{ __('messages.Material') }}" +'</a></li>\
                            <li><a href="#" class="ftMDelete">'+ "{{ __('messages.Delete') }}" +'</a></li>\
                            </ul>\
                        </td>\
                        <td>\
                            <div class="input-field" style="position:relative;">\
                            <input type="text" class="font1 invisInput material-field" autocomplete="off" placeholder="Material" value="'+field1+'" id="material'+newId+'">\
                            <ul class="material-ul" style="display:none;"></ul>\
                            </div>\
                        </td>\
                        <td>\
                            <input type="text" class="font1 invisInput" placeholder="Provider" value="">\
                        </td>\
                        <td>\
                            <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Quantity">\
                        </td>\
                        <td>\
                            <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Cost">\
                        </td>\
                        <td>\
                            <input type="text" inputmode="numeric" class="font1 invisInput" placeholder="Total" readonly>\
                            <img src="'+baseurl+'trash.svg" class="ftDeleteSI">\
                        </td>\
                        </tr>');
        TRNew.children().eq(0).children().first().val('+ Add');
        TRNew.children().eq(1).children().first().val('');
        TRNew.children().eq(2).children().first().val('');
        TRNew.children().eq(3).children().first().val('');
        TRNew.children().eq(4).children().first().val('');
        setDraggable();
        //scrSizes();
        $(".dropdown-trigger").dropdown();
        //set expand
        var tPBody = tBody.parent().parent().parent().parent().parent(),
            sis = tBody.parent().parent().parent().parent(),
            TR = tPBody.children().eq(tPBody.children().index(sis) - 1),
            that = TR.children().first().children(':nth-child(2)').children().first().children().first();
            if (sis.css("display") == "none")
            {
            sis.fadeToggle(200, function() {
                that.text("{{ __('messages.Collapse') }}" + ' ' + "{{ __('messages.Materials') }}");
            });
            }
    }
    $('body').on('click', ".ftCollapse", function() {
		if ($(this).parent().parent().parent().hasClass("ftGSelector")) {
      var that = $(this);
      var tbody = that.parent().parent().parent().parent().parent().parent().children(':nth-child(2)');
      for (var i = 1; i < tbody.children().length - 1; i += 2)
      {
        var that1 = tbody.children().eq(i - 1).children(':first').children(':nth-child(2)').children(':first').children(':first');
        if(that.text() == "{{ __('messages.Expand') }}")
        {
          tbody.children().eq(i).show();
          that1.text("{{ __('messages.Collapse') }}" + ' ' + "{{ __('messages.Materials') }}");
        }
        else
        {
          tbody.children().eq(i).hide();
          that1.text("{{ __('messages.Expand') }}" + ' ' + "{{ __('messages.Materials') }}");
        }
      }
      if(that.text() == "{{ __('messages.Expand') }}")
        that.text("{{ __('messages.Collapse') }}");
      else
        that.text("{{ __('messages.Expand') }}");
		} else {
			var that = $(this),
				TR = $(this).parent().parent().parent().parent(),
				tBody = TR.parent(),
				sis = tBody.children().eq(tBody.children().index(TR) + 1);
			sis.fadeToggle(200, function() {
                if ($(this).css("display") == "none") that.text("{{ __('messages.Expand') }}" + ' ' + "{{ __('messages.Materials') }}");
                else that.text("{{ __('messages.Collapse') }}" + ' ' + "{{ __('messages.Materials') }}");
            });
		}
    });
    if (!isBigDevice()) {
        $(".ftSubitems").each(function() {
            $(this).fadeOut(1);
            var before = $(this).parent().children().eq($(this).parent().children().index($(this)) - 1);
            before.children().first().children().last().children().first().text("{{ __('messages.Expand') }}" + ' ' + "{{ __('messages.Materials') }}");
        });
    }
    $(".ftNewSI td:first-child input").focus(function() {
		if ($(this).val() == "+ {{ __('messages.Add') }}") $(this).select();
	});
    // actual  conversion code starts here

    // var ones = ['', ' {{ __("messages.One") }}', ' {{ __("messages.Two") }}', ' {{ __("messages.Three") }}', ' {{ __("messages.Four") }}', ' {{ __("messages.Five") }}', ' {{ __("messages.Six") }}', ' {{ __("messages.Seven") }}', ' {{ __("messages.Eight") }}', ' {{ __("messages.Nine") }}'];
    // var tens = ['', '', '{{ __("messages.Twenty") }}', '{{ __("messages.Thirty") }}', '{{ __("messages.Forty") }}', '{{ __("messages.Fifty") }}', '{{ __("messages.Sixty") }}', '{{ __("messages.Seventy") }}', '{{ __("messages.Eighty") }}', '{{ __("messages.Ninety") }}'];
    // var teens = ['{{ __("messages.Ten") }}', '{{ __("messages.Eleven") }}', '{{ __("messages.Twelve") }}', '{{ __("messages.Thirteen") }}', '{{ __("messages.Fourteen") }}', '{{ __("messages.Fifteen") }}', '{{ __("messages.Sixteen") }}', '{{ __("messages.Seventeen") }}', '{{ __("messages.Eighteen") }}', '{{ __("messages.Nineteen") }}'];

    // function convert_billions(num) {
    //     if (num >= 1000000000) {
    //         if(Math.floor(num / 1000000) == 1)
    //             return convert_billions(Math.floor(num / 1000000000)) + " {{ __('messages.Billion') }} " + convert_millions(num % 1000000000);
    //         else
    //             return convert_billions(Math.floor(num / 1000000000)) + " {{ __('messages.Billions') }} " + convert_millions(num % 1000000000);
    //     } else {
    //         return convert_millions(num);
    //     }
    // }

    // function convert_millions(num) {
    //     if (num >= 1000000) {
    //         if(Math.floor(num / 1000000) == 1)
    //             return convert_millions(Math.floor(num / 1000000)) + " {{ __('messages.Million') }} " + convert_thousands(num % 1000000);
    //         else
    //             return convert_millions(Math.floor(num / 1000000)) + " {{ __('messages.Millions') }} " + convert_thousands(num % 1000000);
    //     } else {
    //         return convert_thousands(num);
    //     }
    // }

    // function convert_thousands(num) {
    //     if (num >= 1000) {
    //         if(Math.floor(num / 1000) == 1)
    //             return convert_hundreds(Math.floor(num / 1000)) + " {{ __('messages.Thousand') }} " + convert_hundreds(num % 1000);
    //         else
    //             return convert_hundreds(Math.floor(num / 1000)) + " {{ __('messages.Thousands') }} " + convert_hundreds(num % 1000);
    //     } else {
    //         return convert_hundreds(num);
    //     }
    // }

    // function convert_hundreds(num) {
    //     if (num > 99) {
    //         if(Math.floor(num / 100) == 1)
    //             return ones[Math.floor(num / 100)] + " {{ __('messages.Hundred') }} " + convert_tens(num % 100);
    //         else
    //             return ones[Math.floor(num / 100)] + " {{ __('messages.Hundreds') }} " + convert_tens(num % 100);
    //     } else {
    //         return convert_tens(num);
    //     }
    // }

    // function convert_tens(num) {
    //     if (num < 10) return ones[num];
    //     else if (num >= 10 && num < 20) return teens[num - 10];
    //     else {
    //         return tens[Math.floor(num / 10)] + " " + ones[num % 10];
    //     }
    // }

    function convert(num) {
        
        var decimal = parseFloat(num - Math.floor(num));
        var country = "{!! $client->country ?? '' !!}";
        if (num == 0) return "{{ __('messages.Zero') }}";
        else{
            if(decimal == 0)
                return writtenNumber(Math.floor(num), {lang: document.documentElement.lang}) + " " + getCurrencyFromCountry(country) + " " + "00/100";
            else if(decimal < 0.1)
                return writtenNumber(Math.floor(num), {lang: document.documentElement.lang}) + " " + getCurrencyFromCountry(country) + " 0" + Math.floor(decimal * 100) + "/100";
            else
                return writtenNumber(Math.floor(num), {lang: document.documentElement.lang}) + " " + getCurrencyFromCountry(country) + " " + Math.floor(decimal * 100) + "/100";
        } 
    }

    function getCurrencyFromCountry(country) {
        if(country == "Mexico")
            return "MXN";
        else if(country == "Russia")
            return "RUB";
        else if(country == "United Kingdom")
            return "GBP";
        else if(country == "Australia")
            return "AUD";
        else if(country == "Canada")
            return "CAD";
        else if(country == "Japan")
            return "JPY";
        else
            return "USD";
    }
    //end of conversion code

    //testing code begins here
</script>

<script defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqsYlbvunG8q26BV66NAVX3pGEl3lIgdI&libraries=places">
</script>

