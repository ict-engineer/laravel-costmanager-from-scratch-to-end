@extends('layouts.layout')

@section('contentcss')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

<style>
    .paymentSubDiv{
        padding: 2rem 0px !important;
        height: 120px;
        text-align: center;
    }
    @media only screen and (min-width: 601px) {
        .paymentSubDiv1 {
            border-right: 3px solid black;
        }
    }
    #myModal {
        max-width: 500px;
    }
</style>
@endsection
@section('pagetitle')
<h5 class="breadcrumbs-title mt-0 mb-0 display-inline hide-on-small-and-down"><span>{{ __('messages.Payment') }}</span></h5>
<ol class="breadcrumbs mb-0">
    <li class="breadcrumb-item"><a href="/welcome">{{ __('messages.Home') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('messages.Payment') }}
    </li>
</ol>
@endsection
@section('content')
<div class="section section-data-tables">
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col m6 s12 display-flex justify-content-start">
                            <h4 class="card-title" style="display:flex;align-items:center;"><i class="material-icons">attach_money</i>{{ __('messages.Payment') }}</h4>
                        </div>
                    </div>
                    <div class="divider mb-1 mt-1"></div>
                    <div class="row">
                        <div class="col m0 l2"></div>
                        <div class="col m12 l8">
                            <h4 class="mb-5" style="text-align: center;">{{ $payment }}</h4>
                            <div class="row">
                                <div class="col m4 s12 paymentSubDiv paymentSubDiv1">
                                    <p>{{ __('messages.Last Payment') }}</p>
                                    <p>{{ $lastPay }}</p>
                                    <a href='{{ $invoice }}'>{{ __('messages.Invoice') }}</a>
                                </div>
                                <div class="col m4 s12 paymentSubDiv paymentSubDiv1">
                                    <p>{{ __('messages.Next Payment Due') }}</p>
                                    <p>{{ $nextPay }}</p>
                                </div>
                                <div class="col m4 s12 paymentSubDiv">
                                    <p>{{ __('messages.Payment Method') }}</p>
                                    <div class="display-flex justify-content-center">
                                        <img src="{{ asset('imgs/mastercard.png') }}" style="height: 2rem;" ></img>
                                        <p style="font-size:1.4rem;" id="lastfour">****{{ $lastfour }}</p>
                                    </div>
                                    <a href="javascript:void(0);" id="editPayment">{{ __('messages.Edit') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col m0 l2"></div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
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
                
                <form role="form" action="{{ route('user.setPayment') }}" method="post"
                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                    id="payment-form">
                    @csrf
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
                            <p id="errortext"></p>
                        </div>
                    </div>
                    <div class="divider mt-3"></div>

                    <div class="mt-3 user-edit-btns display-flex  justify-content-end ">
                        <button type="submit" class="btn-small indigo" id="saveBtn" value="create">{{ __('messages.Save') }}</button>
                        <a class="btn-small btn-light-pink" id="cancelBtn" style="margin-left:10px;" href="javascript:void(0)" value="cancel">{{ __('messages.Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentjs')
@include('user.client.payment.jsindex')
@endsection