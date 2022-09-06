@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/dashboard.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/dashboard.css') }}">
<style>
    .sweet-alert p {
        text-align: left !important;
    }
    .card-move-up .move-up {
        padding: 20px;
        padding-bottom: 40px;
    }
    .btn-move-up1 {
        position: absolute;
        bottom: 5px !important;
        right: 5px !important;
    }
    .chart-title {
        font-size: 1.3rem;
        font-weight: 500;
    }

    .middle-line:after{
        content:"\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0";
        text-decoration:line-through;
        color: white;
        font-size:1.7rem;
        font-weight:1000;
    }
}
</style>
@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.Dashboard') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.Dashboard') }}
    </li>
</ol>
@endsection
@section('content')
<div class="section">
    <div class="row">
        <div class="col m2 s12">
            <label for="fromDate">{{ __('messages.From') }}</label>
            <input type="text" class="" id="fromDate" style="border-bottom:0px solid white;">
        </div>
        <div class="col m2 s12">
            <label for="toDate">{{ __('messages.To') }}</label>
            <input type="text" class="" id="toDate" style="border-bottom:0px solid white;">
        </div>
        <div class="col m2 s12">
            <div class="switch display-flex align-items-center" style="padding-top:30px;">
                <label class="display-flex">
                {{ __('messages.Month') }} <input type="checkbox" id="checkMonth" /> <span class="lever" style="margin-left:7px;margin-right:7px;"></span> {{ __('messages.Year') }}
                </label>
            </div>
        </div>
        <div class="col m6 s12"></div>
    </div>
    <div id="card-stats" class="pt-0">
        <div class="row">
            <div class="col s12 m6 l3">
                <div class="card animate fadeLeft">
                    <div class="card-content cyan white-text">
                        <p class="card-stats-title"><i class="material-icons">person_outline</i> {{ __('messages.Clients') }}</p>
                        <h4 class="card-stats-number white-text" id="clientsState"></h4>
                        <!-- <p class="card-stats-compare">
                            <i class="material-icons">keyboard_arrow_up</i> 15%
                            <span class="cyan text text-lighten-5">from yesterday</span>
                        </p> -->
                    </div>
                    <div class="card-action cyan darken-1">
                        <div id="clients-bar" class="center-align"></div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="card animate fadeLeft">
                    <div class="card-content red accent-2 white-text">
                        <p class="card-stats-title"><i class="material-icons">attach_money</i>{{ __('messages.Total Quoted') }}</p>
                        <h4 class="card-stats-number white-text" id="quotesState"></h4>
                        <!-- <p class="card-stats-compare">
                            <i class="material-icons">keyboard_arrow_up</i> 70% <span class="red-text text-lighten-5">last
                                month</span>
                        </p> -->
                    </div>
                    <div class="card-action red">
                        <div id="sales-compositebar" class="center-align"></div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="card animate fadeRight">
                    <div class="card-content orange lighten-1 white-text">
                        <p class="card-stats-title"><i class="material-icons">trending_up</i> {{ __('messages.Total Invoiced') }}</p>
                        <h4 class="card-stats-number white-text" id="invoicesState"></h4>
                        <!-- <p class="card-stats-compare">
                            <i class="material-icons">keyboard_arrow_up</i> 80%
                            <span class="orange-text text-lighten-5">from yesterday</span>
                        </p> -->
                    </div>
                    <div class="card-action orange">
                        <div id="profit-tristate" class="center-align"></div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l3">
                <div class="card animate fadeRight">
                    <div class="card-content green lighten-1 white-text">
                        <p class="card-stats-title"><i class="material-icons">content_copy</i> {{ __('messages.Total Paid') }}</p>
                        <h4 class="card-stats-number white-text" id="paidInvoicesState"></h4>
                        <!-- <p class="card-stats-compare">
                            <i class="material-icons">keyboard_arrow_down</i> 3%
                            <span class="green-text text-lighten-5">from last month</span>
                        </p> -->
                    </div>
                    <div class="card-action green">
                        <div id="invoice-line" class="center-align"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--card stats end-->
    <!--chart dashboard start-->
    <div id="chart-dashboard">
        <div class="row">
            <div class="col s12">
                <div class="card animate fadeUp">
                    <div class="card-move-up waves-effect waves-block waves-light">
                        <div class="move-up cyan darken-1">
                            <div class="row">
                                <div class="col m6 s12 mb-1">
                                    <div class="display-flex align-items-center">
                                        <span class="chart-title white-text" style="width: 10rem;display: inline-block;">{{ __('messages.Quotes') }}</span><span style="color:white;display: inline-block;font-weight:1000;font-size:1.7rem;">-----------</span>
                                    </div>
                                    <div class="display-flex align-items-center" style="margin-top:-10px;">
                                        <span class="chart-title white-text" style="width: 10rem;display: inline-block;">{{ __('messages.Invoices') }}</span><span class="middle-line"></span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="trending-line-chart-wrapper"><canvas id="revenue-line-chart" height="70"></canvas>
                            </div>
                        </div>
                        <a class="btn-floating btn-move-up1 waves-effect waves-light red accent-2 z-depth-4 right">
                            <i class="material-icons activator">filter_list</i>
                        </a>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4"> <i class="material-icons right">close</i>
                        </span>
                        <table class="responsive-table">
                            <thead>
                                <tr>
                                    <th data-field="id">{{ __('messages.Date') }}</th>
                                    <th data-field="month">{{ __('messages.Invoices') }}</th>
                                    <th data-field="item-sold">{{ __('messages.Quotes') }}</th>
                                </tr>
                            </thead>
                            <tbody id="detailTBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
@section('contentjs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="{{ asset('app-assets/vendors/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('js/client_dashboard.js') }}"></script>

<script>
    var isFirst = '{!! $isFirst ?? '' !!}';
    var toDate = new Date().toJSON().slice(0,10).replace(/-/g,'/');
    var tmpDate = new Date();
    tmpDate.setDate(1);
    var fromDate = tmpDate.toJSON().slice(0,10).replace(/-/g,'/');

    function z(x) {
        var parts=x.toString().split(".");
        return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
    }

    $('#fromDate').val(fromDate);
    $('#toDate').val(toDate);
    
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
    function setGraph()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = '{{ route("getGraphInfo") }}'; 
        var graph_data = {};
        $.ajax({
            url: url,
            data: {fromDate:$('#fromDate').val(), toDate:$('#toDate').val(), isMonth:Number($('#checkMonth').prop("checked"))},
            type: "POST",
            dataType: 'json',
            success: function (data) {
                graph_data = data['data'];

                $('#detailTBody').empty();
                for(var i = 0; i < graph_data['labels'].length; i ++)
                {
                    $('#detailTBody').append('<tr><td>' + graph_data['labels'][i] + 
                                            '</td><td>$' + z(graph_data['invoices'][i]) + '</td><td>$' +
                                            z(graph_data['quotes'][i]) + '</td></tr>');
                }

                var revenueLineChartData = {
                    labels: graph_data['labels'],
                    datasets: [
                        {
                            label: "Today",
                            data: graph_data['invoices'],
                            backgroundColor: "rgba(128, 222, 234, 0.5)",
                            borderColor: "#d1faff",
                            pointBorderColor: "#d1faff",
                            pointBackgroundColor: "#00bcd4",
                            pointHighlightFill: "#d1faff",
                            pointHoverBackgroundColor: "#d1faff",
                            borderWidth: 2,
                            pointBorderWidth: 2,
                            pointHoverBorderWidth: 4,
                            pointRadius: 4
                        },
                        {
                            label: "Second dataset",
                            data: graph_data['quotes'],
                            borderDash: [15, 5],
                            backgroundColor: "rgba(128, 222, 234, 0.2)",
                            borderColor: "#80deea",
                            pointBorderColor: "#80deea",
                            pointBackgroundColor: "#00bcd4",
                            pointHighlightFill: "#80deea",
                            pointHoverBackgroundColor: "#80deea",
                            borderWidth: 2,
                            pointBorderWidth: 2,
                            pointHoverBorderWidth: 4,
                            pointRadius: 4
                        }
                    ]
                };
                var revenueLineChartConfig = {
                    type: "line",
                    options: revenueLineChartOptions,
                    data: revenueLineChartData
                };
                var meta = revenueLineChart && revenueLineChart.data && revenueLineChart.data.datasets[0]._meta;
                for (let i in meta) {
                    if (meta[i].controller) meta[i].controller.chart.destroy();
                }

                revenueLineChart = new Chart(revenueLineChartCTX, revenueLineChartConfig);
            },
            error: function (data) {
            }
        });

        var url = '{{ route("getClientDashboardInfo") }}'; 
        $.ajax({
            url: url,
            data: {fromDate:$('#fromDate').val(), toDate:$('#toDate').val(), isMonth:Number($('#checkMonth').prop("checked"))},
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#clientsState').text(data['data']['clients']);
                $('#quotesState').text(data['data']['quotes']);
                $('#invoicesState').text(data['data']['invoices']);
                $('#paidInvoicesState').text(data['data']['paidInvoices']);
            },
            error: function (data) {
            }
        });
    }

    setGraph();

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
        })
   
        setGraph();
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
        })
        setGraph();
    });
    
    $("body").on("change","#checkMonth",function(e){
        if($('#checkMonth').prop("checked"))
        {
            toDate = new Date().toJSON().slice(0,10).replace(/-/g,'/');
            tmpDate = new Date();
            tmpDate.setFullYear(tmpDate.getFullYear() - 1);
            fromDate = tmpDate.toJSON().slice(0,10).replace(/-/g,'/');

            $('#fromDate').val(fromDate);
            $('#toDate').val(toDate);
        }
        else
        {
            toDate = new Date().toJSON().slice(0,10).replace(/-/g,'/');
            tmpDate = new Date();
            tmpDate.setMonth(tmpDate.getMonth() - 1);
            fromDate = tmpDate.toJSON().slice(0,10).replace(/-/g,'/');

            $('#fromDate').val(fromDate);
            $('#toDate').val(toDate);
        }
        setGraph();
    });
    if(isFirst == 'yes')
    {
        var userName = '{!! $userName ?? '' !!}';
        var date = '{!! $date ?? '' !!}';
        swal({
            title: "",
            text: "{{ __('messages.Dear') }} "+" "+userName+":\n\n"+"{{ __('messages.Thank you very much for being part of our community of contractors and being a user of The Quote Box. According to the terms of your contract, from now on you have a free trial month and an automatic charge will be made to your card on ') }}"+date+". "+"{{ __('messages.Remember that you can cancel The Quote Box services at any time.\nAffectionately: The Quote Box Team') }}",
            type: "success",
            showCancelButton: false,
            dangerMode: true,
            confirmButtonColor: '#7cd1f9',
            confirmButtonText: 'OK',
        },function (result) {
            $('#submitForm').submit();
        });                    
    }
    
</script>
@endsection

