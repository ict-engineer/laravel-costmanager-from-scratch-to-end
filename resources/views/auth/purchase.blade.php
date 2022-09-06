@extends('layouts.setlayout')

@section('contentcss')
<link rel="stylesheet" type="text/css" href="{{ asset('custom_components/purchase.css') }}">
<style>
    .priceSection {
        background-color: #fff;
        padding: 20px 10px;
        border-radius: 3px;
    }
    @media only screen and (max-width: 375px) {
        .cardimage {
            width: 145px;
            height: 30px;
        }
    }
    #myModal {
        max-width: 500px;
    }
    .btn-small{
        padding: 0px 20px;
    }
    .price-box .price-rate .rate {
        font-size: 45px;
    }
    .description {
        text-align: left;
        height: 16rem;
    }
    .signup-btn{
        color: #ffffff;
        padding: 10px 25px;
        border-radius: 35px;
        background-color: rgba(255, 255, 255, 0.3);
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        font-size: 14px;
    }
    .numberusers {
        color: #768ede;
        font-size: 1.5rem;
    }
    .signup-btn:hover {
        background-color: rgba(255, 255, 255, 1);
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
</style>
@endsection

@section('content')
<div>
<section class="priceSection">
@if(Session::get('stripeError') != '')
    <div class="card-alert card cyan lighten-5" id="expireText">
        <div class="card-content cyan-text">
            <p>{{ Session::get('stripeError') }}</p>
        </div>
    </div> 
@endif
    <div class="container">
        <div class="row">
            @foreach ($payments as $payment)
            <div class="col s12 m{{ 12/count($payments) }}">
                <div class="price-box" style="height:75%;min-width:215px;">
                    <div class="price-header">
                        <div class="price-icon">
                        @if ($loop->index == 0)
                            <span class="lnr lnr-rocket"></span>
                        @elseif ($loop->index == 1)
                            <span class="lnr lnr-diamond"></span>
                        @else
                            <span class="lnr lnr-pie-chart"></span>
                        @endif
                        </div>
                        <h4 style="text-transform: uppercase;">{{ $payment->name }}</h4>
                    </div>
                    <div class="price-body">
                        <ul>
                            <li class="description" data-id="{{ $loop->index }}"></li>
                        </ul>
                    </div>
                    <div class="price-rate"  style="padding-left:1rem;padding-right:1rem;">
                        <span class="rate">{{ $payment->price }}</span> <small>{{ $payment->currency }}/{{ __('messages.Month') }}</small>
                    </div>
                    <div class="price-footer">
                        <a href="javascript:void(0)" class="bttn-white purchaseBtn" style="margin-right:0px;" data-id='{{ $loop->index }}'>{{ __('messages.Purchase') }}</br>{{ __('messages.1 Month Trial') }}</a>
                    </div>
                </div>
                <div class="space-30 hidden visible-xs"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<div class="display-flex justify-content-center mt-1 price-footer">
    <a class="signup-btn" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        {{ __('messages.Sign Out') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
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
                   
                <form role="form" action="{{ route('stripepost') }}" method="post"
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
<!-- End Modal -->
@endsection

@section('contentjs')
<!-- jquery-validation -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

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
                    data: $form.serialize(),
                    url: "{{ route('stripepost') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        if(data['text']  == "success")
                            document.location.href = "{{ route('welcome') }}";
                        else
                        {
                            $('.errortext')
                                .removeClass('hide')
                                .find('#errortext')
                                .text(data['error']);
                        }
                    },
                    error: function (data) {
                        $('.errortext')
                                .removeClass('hide')
                                .find('#errortext')
                                .text("Failed");
                        $('#progressModal').modal('close');
                    },
                    complete: function (data) {
                        $('#progressModal').modal('close');
                    }
                });
            }
        }
    });
</script>

@endsection
