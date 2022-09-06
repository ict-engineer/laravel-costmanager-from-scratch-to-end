@extends('layouts.sign')

@section('title')
Login
@endsection
@section('content')
<div class="container-login100">
    <div class="wrap-login100 p-l-35 p-r-35 p-t-45 p-b-44">
        <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
            @csrf
            <span class="login100-form-logo">
			    <img width="100" src="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}"></img>
			</span>
            <span class="login100-form-title p-b-39">
                {{  __('messages.Login') }}
            </span>
            <div class="wrap-input100 validate-input m-b-23" data-validate = "Email is reauired">
                <span class="label-input100">{{  __('messages.E-Mail Address') }}</span>
                <input class="input100" type="text" name="email" id="email" placeholder="{{ __('messages.Type your') }} {{ __('messages.E-Mail Address') }}"  value="{{ old('email') }}" autocomplete="email" autofocus>
                <span class="focus-input100" data-symbol="&#xf206;"></span>
            </div>
                
            <div class="wrap-input100 validate-input" data-validate="Password is required">
                <span class="label-input100">{{  __('messages.Password') }}</span>
                <input class="input100" type="password" name="password" id="password" placeholder="{{ __('messages.Type your') }} {{ __('messages.Password') }}"  autocomplete="password"  value="{{ old('password') }}">
                <span class="focus-input100" data-symbol="&#xf190;"></span>
            </div>
            
            <div class="p-t-25 p-b-16" style="text-align:right;">
                <!-- <div class="contact100-form-checkbox">
                    <input class="input-checkbox100" id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="label-checkbox100" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div> -->
                <a href="{{ route('password.request') }}">
                    {{  __('messages.Forgot Password') }}
                </a>
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
                        {{  __('messages.Login') }}
                    </button>
                </div>
            </div>
            
            <div class="txt1 text-center p-t-34 p-b-20">
                <span>
                    {{  __('messages.Or Register Using')}}
                </span>
            </div>

            <div class="flex-c-m">
                <a href="{{ url('auth/facebook') }}" class="login100-social-item bg1">
                    <i class="fa fa-facebook"></i>
                </a>

                <a href="{{ url('auth/google') }}" class="login100-social-item bg3">
                    <i class="fa fa-google"></i>
                </a>
            </div>

            <div class="flex-col-c p-t-35">
                <a href="{{ route('register') }}" class="txt2">
                    {{  __('messages.Register') }}
                </a>
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
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
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

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->