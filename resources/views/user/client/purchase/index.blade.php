@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('custom_components/purchase.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/pricing.css') }}">
<style>
    #myModal {
        max-width: 500px;
    }
    .description {
        text-align: left;
        padding-top: 2rem;
        padding-left: 2rem;
        height: 16rem;
    }
    .isDisabled {
        color: currentColor;
        cursor: not-allowed;
        opacity: 0.5;
        text-decoration: none;
    }
    .sweet-alert p {
        text-align: left !important;
    }
    #progressModal {
        top:40% !important;
        line-height: 50px;
        text-align:center;
        width:250px; 
        height: 50px;
        background-color:rgb(255, 122, 112);
        color:white;
    }
    .card-action a{
      height: 40px;
    }
    .card-action{
      padding: 16px;
    }
</style>
@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.Membership Plan') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.Membership Plan') }}
    </li>
</ol>
@endsection
@section('content')
<div class="row">
    @if(count($payments) == 1)
    <div class="col s12 m3 l4"></div>
    <div class="col s12 m6 l4">
    @elseif(count($payments) == 2)
    <div class="col s12 m12 l2"></div>
    <div class="col s12 m12 l8">
    @else
    <div class="col s12 m12 l12">
    @endif
        <div id="basic-tabs" class="card card card-default scrollspy">
            <div class="card-content">
                <div class="row">
                    <div class="row">
                        <div class="col m6 s12">
                            <h5>{{ __('messages.Membership') }}</h5>
                        </div>
                        <div class="col m6 s12 display-flex justify-content-end align-items-bottom mt-1">
                            @if(!$isAvaliable)
                            <button id="cancelAccount" class="btn btn-light-pink">{{ __('messages.Cancel') }} {{ __('messages.Account') }}</button>
                            @endif
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="row">
                            <div class="plans-container">
                                @foreach ($payments as $payment)
                                @if(count($payments) == 1)
                                    <div class="col s12">
                                @elseif(count($payments) == 2)
                                    <div class="col s12 m6 l6">
                                @else
                                    <div class="col s12 m6 l4">
                                @endif
                                    
                                    @if ($loop->index == 0)
                                        <div class="card hoverable animate fadeLeft">
                                        <div class="card-image gradient-45deg-light-blue-cyan waves-effect">
                                    @elseif ($loop->index == 1)
                                        <div class="card hoverable animate fadeUp">
                                        <div class="card-image gradient-45deg-red-pink waves-effect">
                                    @elseif ($loop->index == 2)
                                        <div class="card hoverable animate fadeRight">
                                        <div class="card-image gradient-45deg-amber-amber accent-2 waves-effect">
                                    @elseif ($loop->index == 3)
                                        <div class="card hoverable animate fadeLeft">
                                        <div class="card-image teal darken-2 waves-effect">
                                    @endif
                                            <div class="card-title">{{ $payment->name }}</div>
                                            <div class="price">
                                                <span class="rate">{{ $payment->price }}</span> <small>{{ $payment->currency }}/{{ __('messages.Month') }}</small>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <ul class="collection">
                                                <li class="description" data-id="{{ $loop->index }}"></li>
                                            </ul>
                                        </div>
                                        <div class="card-action center-align">
                                            @if ($currentPlan == $payment->id && $currentPlan == Auth::user()->client->payment)
                                                <a href="javascript:void(0)" class="isDisabled waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow btn" style="margin-right:0px;color:lightgray;line-height: 20px;" data-id='{{ $loop->index }}'>{{ __('messages.Current Plan') }}</br>({{ __('messages.Renews') }} {{ $dateStr }})</a>
                                            @elseif ($currentPlan == $payment->id && $currentPlan != Auth::user()->client->payment)
                                                <a href="javascript:void(0)" class="purchaseBtn waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow btn" style="margin-right:0px;color:lightgray;line-height: 20px;" data-id='{{ $loop->index }}'>{{ __('messages.Current Plan') }}</br>({{ __('messages.Upgrade') }})</a>
                                            @elseif (Auth::user()->client->payment == $payment->id && $currentPlan != Auth::user()->client->payment)
                                                <a href="javascript:void(0)" class="isDisabled waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow btn" style="margin-right:0px;color:lightgray;" data-id='{{ $loop->index }}'>{{ __('messages.Renews') }} {{ $dateStr }}</a>
                                            @else
                                                <a href="javascript:void(0)" class="purchaseBtn waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow btn" style="margin-right:0px;" data-id='{{ $loop->index }}'>{{ __('messages.Upgrade') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->


<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="display-flex justify-content-between">
                    <h6 class="modal-title" id="modalheader">{{ __('messages.Payment') }}</h6>
                    <img class="cardimage" src="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}" width="35" height="35"></img>
                </div>
            </div>
            <div class="divider mt-1" style="margin-bottom:10px;"></div>

            <div class="modal-body">
                
                <form role="form" action="{{ route('user.setpurchaseplan') }}" method="post"
                    data-cc-on-file="false"
                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                    id="payment-form">
                    @csrf
                    <input type="hidden" name="amount" id="amount">
                    <input type="hidden" name="currency" id="currency">
                    <input type="hidden" name="paymentid" id="paymentid">
                    <input type="hidden" name="stripeToken" id="stripeToken">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">{{ __('messages.Card Number') }}</label>
                            <input class="validate card-number" type="text" name="cardnumber" id="cardnumber" autocomplete='off' size='20' placeholder="Card Number" required>
                        </div>                 
                    </div>
                    <div class="row">
                        <div class="col m4 s12">
                            <label for="name">{{ __('messages.Expiration Month') }}</label>
                            <input class="validate card-expiry-month" type="text" name="expirymonth" onKeyPress="if(this.value.length==2) return false;"  id="expirymonth" autocomplete='off' size='2' placeholder="MM" required>
                        </div>
                        <div class="col m4 s12">
                            <label for="name">{{ __('messages.Expiration Year') }}</label>
                            <input class="validate card-expiry-year" type="text" name="expiryyear" onKeyPress="if(this.value.length==4) return false;"  id="expiryyear" autocomplete='off' size='4' placeholder="YYYY" required>
                        </div>
                        <div class="col m4 s12">
                            <label for="name">CVC</label>
                            <input class="validate card-cvc" type="text" name="cvv" id="cvv" autocomplete='off' size='4' placeholder="Ex. 123" required>
                        </div>
                    </div>

                    <div class="card-alert card red lighten-5 hide errortext">
                        <div class="card-content red-text">
                            <p id="errortext">Purchase for 40$ membership.</p>
                        </div>
                    </div>

                    <div class="divider mt-3"></div>

                    <div class="mt-3 user-edit-btns display-flex  justify-content-end ">
                        <button type="submit" class="btn-small indigo" id="saveBtn" value="create">{{ __('messages.Pay Now') }}</button>
                        <button class="btn-small btn-light-pink" id="cancelBtn" style="margin-left:10px;" href="javascript:void(0)" value="cancel">{{ __('messages.Cancel') }}</button>
                    </div>
                </form>

                
            </div>
        </div>
        <div id="progressModal" class="modal fade" role="dialog">
            {{ __('messages.Processing...') }}
        </div>
    </div>
    
</div>

@endsection
@section('contentjs')
<!-- jquery-validation -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
    $(document).ready(function(){
        var payments = {!! $payments !!};
        for(var i = 0; i < payments.length; i ++)
        {
            $('li[data-id="'+i+'"]').html(payments[i].description);
        }
        
        $('#cancelBtn').click(function (e) {
            e.preventDefault();
            $('.errortext').addClass('hide');
            $('#myModal').modal('close');
        });
        $('body').on('click', '.purchaseBtn', function (e) {
            var id = $(this).data('id');
            $('#amount').val(payments[id].price);
            $('#currency').val(payments[id].currency);
            $('#paymentid').val(payments[id].id);
            $('#saveBtn').html("{{ __('messages.Pay Now') }}" + '('+payments[id].price+payments[id].currency+')');
            $('#payment-form').trigger("reset");
            $('#myModal').modal()[0].M_Modal.options.dismissible = false;
            $('#myModal').modal('open');
            $('#cardnumber').focus();
        });

        $('#payment-form').bind('submit', function(e) {
            $form = $('#payment-form');
            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                $('#progressModal').modal()[0].M_Modal.options.dismissible = false;
                $('#progressModal').modal('open');
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }
        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.errortext')
                    .removeClass('hide')
                    .find('#errortext')
                    .text(response.error.message);
                $('#progressModal').modal('close');
            } else {
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                $('#stripeToken').val(token);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    data: $('#payment-form').serialize(),
                    url: "{{ route('user.setpurchaseplan') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        if(data['text']=='success')
                        {
                            $(".errortext").html('');
                            $('.errortext').addClass('hide');
                            // $('#expensetype').val($("#expensetype option:first").val()).change();
                            $('#payment-form').trigger("reset");
                            $('#myModal').modal('close');
                            swal({
                                title: "",
                                text: "{{ __('messages.Dear') }}" + " "+data['userName']+":\n\n"+"{{ __('messages.Thank you very much for being part of our community of contractors and being a user of The Quote Box. According to the terms of your contract, from now on you have a free trial month and an automatic charge will be made to your card on ') }}"+data['date']+". "+"{{ __('messages.Remember that you can cancel The Quote Box services at any time.Affectionately: The Quote Box Team') }}",
                                type: "success",
                                showCancelButton: false,
                                dangerMode: true,
                                confirmButtonColor: '#7cd1f9',
                                confirmButtonText: 'OK',
                            },function (result) {
                                document.location.href = "{{ route('user.purchaseplan') }}";      
                            });            
                            
                        }
                        else
                        {
                            $('.errortext')
                                .removeClass('hide')
                                .find('#errortext')
                                .text(data['error']);
                        }
                    },
                    error: function (data) {
                        $('#progressModal').modal('close');
                    },
                    complete: function (data) {
                        $('#progressModal').modal('close');
                    }
                });
            }
        }

        $("body").on("click","#cancelAccount",function(){
            var current_object = $(this);
            var username = '{!! Auth::user()->name !!}';
            var dateStr = '{!! $dateStr !!}';
            swal({
                title: "",
                text: "{{ __('messages.Dear') }}"+" " + username + "!\n" + "{{ __('messages.You are free to cancel at any time. If you wish to cancel now, you will have access to the system until ') }}"+dateStr+". "+"{{ __('messages.Once the period is over, your information will be safe for the next month and you can return and hire the plan that suits you best.') }}",
                type: "warning",
                showCancelButton: true,
                dangerMode: true,
                cancelButtonClass: '#DD6B55',
                confirmButtonColor: '#dc3545',
                cancelButtonText: '{{ __("messages.Don´t want to cancel") }}',
                confirmButtonText: '{{ __("messages.Proceed to cancel") }}',
            },function (result) {

                if(result){
                    M.toast({
                        html: "{{ __('messages.Canceling account') }}",
                        classes: 'rounded',
                        displayLength: 100000000,
                    });
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "get",
                        url: "{{ route('user.cancelPurchaseplan') }}",
                        success: function (data) {
                            var toastElement = document.querySelector('.toast');
                            var toastInstance = M.Toast.getInstance(toastElement);
                            toastInstance.dismiss();
                            M.toast({
                                html: data['success'],
                                classes: 'rounded'
                            });
                            document.location.href = '/setpurchase';
                        },
                        error: function (data) {
                            var toastElement = document.querySelector('.toast');
                            var toastInstance = M.Toast.getInstance(toastElement);
                            toastInstance.dismiss();
                            M.toast({
                                html: "Failed",
                                classes: 'rounded'
                            });
                        }
                    });
                }
            });
        });
    });
</script>

@endsection