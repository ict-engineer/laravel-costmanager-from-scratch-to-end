@extends('layouts.sign')

@section('content')
<div class="container-login100">
    <div class="wrap-login100 p-l-35 p-r-35 p-t-45 p-b-44">
        <span class="login100-form-logo">
            <img width="100" src="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}"></img>
        </span>
        <span class="login100-form-title p-b-39">
            {{ __('messages.Verify Your Email Address') }}
        </span>

        <div>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('messages.A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('messages.Before proceeding, please check your email for a verification link.') }}
            {{ __('messages.If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('messages.click here to request another') }}</button>.
            </form>
        </div>
        
        <div class="container-login100-form-btn m-t-30 p-b-15">
            <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <a class="login100-form-btn" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('messages.Sign Out') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection
