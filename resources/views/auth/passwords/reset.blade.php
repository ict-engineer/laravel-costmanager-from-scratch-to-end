@extends('layouts.sign')

@section('title')
{{ __('messages.Reset Password') }}
@endsection
@section('content')
<div class="container-login100">
    <div class="wrap-login100 p-l-35 p-r-35 p-t-45 p-b-44">
        <form class="login100-form validate-form" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <span class="login100-form-logo">
			    <img width="100" src="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}"></img>
			</span>
            <span class="login100-form-title p-b-39">
                {{ __('messages.Choose your Password') }}
            </span>
            <div class="wrap-input100 validate-input m-b-8" data-validate = "Email is reauired">
                <span class="label-input100">{{ __('messages.E-Mail Address') }}</span>
                <input class="input100" type="text" name="email" id="email" placeholder="{{ __('messages.Type your') }} {{ __('messages.E-Mail Address') }}"  value="{{ $email ?? old('email') }}" autofocus>
                <span class="focus-input100" data-symbol="&#xf206;"></span>
            </div>

            <div class="p-b-15 text-center">
                @error('email')
                    <p role="alert" class="error-message">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror
            </div>

            <div class="wrap-input100 validate-input m-b-8" data-validate="Password is required">
                <span class="label-input100">{{ __('messages.Password') }}</span>
                <input class="input100" type="password" name="password" id="password" placeholder="{{ __('messages.Type your') }} {{ __('messages.Password') }}">
                <span class="focus-input100" data-symbol="&#xf190;"></span>
            </div>

            <div class="p-b-15 text-center">
                @error('password')
                    <p role="alert" class="error-message">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror
            </div>

            <div class="wrap-input100 validate-input m-b-45" data-validate="Confirm Password is required">
                <span class="label-input100">{{ __('messages.Confirm Password') }}</span>
                <input class="input100" type="password" name="password_confirmation" id="password-confirm" placeholder="{{ __('messages.Type your') }} {{ __('messages.Password') }}">
                <span class="focus-input100" data-symbol="&#xf190;"></span>
            </div>

            <div class="container-login100-form-btn">
                <div class="wrap-login100-form-btn">
                    <div class="login100-form-bgbtn"></div>
                    <button class="login100-form-btn" type="submit">
                        {{ __('messages.Reset Password') }}
                    </button>
                </div>
            </div>
            
        </form>
    </div>
</div>
@endsection

<!-- 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->