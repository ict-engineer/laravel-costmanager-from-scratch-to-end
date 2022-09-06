@extends('layouts.setlayout')

@section('contentcss')
<link rel="stylesheet" href="{{ asset('custom_components/function_table/css/main.css') }}" type="text/css">
<style>
    .invoice-subtotal-title-preview {
        width: 110px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    .bold-weight-font {
        font-weight: 900;
    }
    .big-font {
        font-size: 18px;
    }
    .invoice-subtotal-title {
        display: flex;
        align-items: center;
        text-align: right;
    }
    .print-area {
        color: black;
        font-weight: 300;
    }

    #quoteLogoImage {
        max-height: 100px;
        margin-bottom: 2px;
    }
</style>
@endsection

@section('content')
<div class="pt-3 pb-3 pl-2 pr-2" style="width: 80%; max-width: 1000px;">
    <div class="card">
        <div class="card-content print-area">
                <div class="display-flex justify-content-between">
                    <img id="quoteLogoImage" src="{{ $data['companyLogo'] }}"></img>
                    <span class="big-font bold-weight-font"  style="margin-top: auto;" id="dateText">{{ $data['date'] }}</span>
                </div>
                <div class="divider mb-1" style="background-color: rgb(33, 120, 135); height: 4px;"></div>
            <div class="quoteInfo mb-5">
                <div class="display-flex align-items-center justify-content-between">
                    <span class="big-font bold-weight-font" id="preClient">{{ $data['client'] }}</span>
                    <span class="big-font bold-weight-font" id="preQuoteNumber">{{ $data['quoteId'] }}</span>
                </div>
                <div class="display-flex align-items-center">
                    <span class="big-font" id="prePhone">{{ $data['phone'] }}</span>
                </div>
                <div class="display-flex align-items-center">
                    <span class="big-font" id="preCompany">{{ $data['companyname'] }}</span>
                </div>
                <div class="display-flex align-items-center">
                    <span class="big-font" id="preEmail">{{ $data['email'] }}</span>
                </div>
                <div class="display-flex align-items-center">
                    <span class="big-font" id="preProject">{{ $data['project'] }}</span>
                </div>
            </div>
            <div id="preMain">
            </div>
            <div class = "subtotal">
                <div class="row">
                    <div class="col l6 m6 s12">
                    </div>
                    <div class="col l6 m6 s12">
                        <li class="display-flex justify-content-between">
                            <span class="invoice-subtotal-title-preview bold-weight-font">SubTotal</span>
                            <h6 class="invoice-subtotal-value bold-weight-font" id="previewSubtotal">$0.00</h6>
                        </li>
                        <li class="display-flex justify-content-between" id="discountRow">
                            <span class="invoice-subtotal-title-preview bold-weight-font" id="preDiscountHeader">Discount</span>
                            <h6 class="invoice-subtotal-value bold-weight-font" id="previewDiscount">-$0.00</h6>
                        </li>
                        <li class="display-flex justify-content-between">
                            <span class="invoice-subtotal-title-preview big-font bold-weight-font">Total</span>
                            <h6 class="invoice-subtotal-value big-font bold-weight-font" id="previewTotal">0.00$</h6>
                        </li>
                        <li class="display-flex justify-content-between" id="advanceRow">
                            <span class="invoice-subtotal-title" id="preAdvanceHeader" style="justify-content: flex-end; width: 110px;">Advance</span>
                            <h6 class="invoice-subtotal-value" id="previewAdvance">0.00$</h6>
                        </li>
                    </div>
                </div>
            </div>
            <div style="text-align: center;margin-top: 3rem;">
                <span class="bold-weight-font" id="footerText">{{ $data['footerText'] }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('contentjs')
<script>
    function z(x) {
    var parts=x.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
    }

    function z1(x, symbol) {
    var parts=x.toString().split(".");
    return symbol + parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
    }
    $(document).ready(function () {
        var groups =  @json($groups);
        var services = @json($services);
        var employees = @json($employees);
        itemCount = 0;
        var showMaterial = "{!! $showMaterial ?? 0 !!}";
        var showService = "{!! $showService ?? 0 !!}";
        var showEmployee = "{!! $showEmployee ?? 0 !!}";
        var showOnlyTotal = "{!! $showOnlyTotal ?? '' !!}";
        var isMaterial = false;
        //items
        var discountTotal = parseFloat('{!! $data["discountTotal"] !!}');
        var shopdaysTotal = parseFloat('{!! $data["shopdaysTotal"] !!}');
        var unpreventedTotal = parseFloat('{!! $data["unpreventedTotal"] !!}');
        var itemTotal = parseFloat('{!! $data["itemTotal"] !!}');
        var servicesTotal = parseFloat('{!! $data["servicesTotal"] !!}');
        var employeesTotal = parseFloat('{!! $data["employeesTotal"] !!}');
        var subTotal = parseFloat('{!! $data["subTotal"] !!}');
        var Total = parseFloat('{!! $data["Total"] !!}');
        var advance = parseFloat('{!! $data["advance"] !!}');
        var discount = parseFloat('{!! $data["discount"] !!}');
        $('#previewTotal').text(z1(Total.toFixed(2), '$'));

        for (var i = 0; i < groups.length; i ++)
        {
            itemCount = itemCount + groups[i]['items'].length;
        }

        for (var i = 0; i < groups.length; i ++)
        {
            $('#preMain').append('<span class="big-font bold-weight-font">'+groups[i]['name']+'</span>');
            $('#preMain').append('<table class="groupTable striped">\
                                <thead>\
                                <tr><th style="width:15%;">Quantity</th><th style="width:55%; text-align: left">Description</th><th class="totalField" style="width:15%;">Unit Price</th><th class="totalField" style="width:15%; text-align: right">Total</th></tr>\
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
        itotal = parseFloat(itotal);
        itotal = itotal.toFixed(2);
        var subTo = subTotal + unpreventedTotal;
        subTo = parseFloat(subTo);
        subTo = subTo.toFixed(2);
        $('#previewSubtotal').text(z1(subTo, '$'));

        if(services.length)
        {
            $('#preMain').append('<span class="big-font bold-weight-font" id="preServicesHeader">External Services</h5>');
            $('#preMain').append('<table class="groupTable striped" id="preServicesBody">\
                                <thead>\
                                <tr><th style="text-align: left;width: 80%;">Description</th><th class="totalField" style="text-align: right;">Total</th></tr>\
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

        if(employees.length)
        {
            $('#preMain').append('<table class="groupTable striped" id="preEmployeesBody">\
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
            $('#preMain').append('<span class="big-font bold-weight-font" id="materialTableHeader">List of Materials</span>');
                $('#preMain').append('<table class="groupTable striped" id="materialTable">\
                                    <thead>\
                                    <tr><th style="text-align: left; width: 80%;">Description</th><th class="totalField" style="text-align: right;">Quantity</th></tr>\
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

        if(showMaterial == true)
        {
            $('#materialTableHeader').show();
            $('#materialTable').show();
        }
        else{
            $('#materialTableHeader').hide();
            $('#materialTable').hide();
        }

        if(showOnlyTotal == true)
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

        if(showService == true)
        {
            $('#preServicesBody').show();
            $('#preServicesHeader').show();
            $('.preServicesTotal').show();
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
        if(showEmployee == true)
        {
            $('#preEmployeesBody').show();
            $('#preEmployeesHeader').show();
            $('.preEmployeesTotal').show();
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

        $('#discountRow').show();
        if(!discount)
            $('#discountRow').hide();
        else
        {
            $('#preDiscountHeader').text('Discount ' + z(discount) + '%');
            $('#previewDiscount').text('-' + z1(discountTotal.toFixed(2), '$'));
        }

        $('#advanceRow').show();
        if(!advance)
            $('#advanceRow').hide();
        else
        {
            var advanceTotal = Total * advance / 100;
            advanceTotal = parseFloat(advanceTotal);
            $('#preAdvanceHeader').text('Advance ' + z(advance) + '%');
            $('#previewAdvance').text(z1(advanceTotal.toFixed(2), '$'));
        }
    });
</script>
@endsection
