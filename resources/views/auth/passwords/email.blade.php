@extends('layouts.sign')

@section('title')
Login
@endsection
@section('content')
<div class="container-login100">
    <div class="wrap-login100 p-l-35 p-r-35 p-t-45 p-b-44">
            @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
        <form class="login100-form validate-form" method="POST" action="{{ route('password.email') }}">
            @csrf
            <span class="login100-form-title p-b-39">
                {{ __('messages.Reset Password') }}
            </span>
            <div class="wrap-input100 validate-input m-b-23" data-validate = "Email is reauired">
                <span class="label-input100">{{ __('messages.E-Mail Address') }}</span>
                <input class="input100" type="text" name="email" id="email" placeholder="{{ __('messages.Type your') }} {{ __('messages.E-Mail Address') }}"  value="{{ old('email') }}" autofocus>
                <span class="focus-input100" data-symbol="&#xf206;"></span>
            </div>
                
            <div class="p-b-15 text-center">
                @error('email')
                    <p role="alert" class="error-message">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror
            </div>

            <div class="container-login100-form-btn">
                <div class="wrap-login100-form-btn">
                    <div class="login100-form-bgbtn"></div>
                    <button class="login100-form-btn" type="submit">
                    {{ __('messages.Send Password Reset Link') }}
                    </button>
                </div>
            </div>
            <div class="m-t-15" style="text-align:center">
                <a href="{{ route('login') }}"><i class="lnr lnr-arrow-left-circle"></i> {{ __('messages.Back') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('jscontent')
@endsection


<!-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->
