@extends('layouts.sign')

@section('title')
Login
@endsection
@section('content')
<div class="container-login100">
    <div class="wrap-login100 p-l-35 p-r-35 p-t-25 p-b-24">
        <form class="login100-form validate-form" id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf
            <span class="login100-form-logo">
                <img width="100" src="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}"></img>
			</span>
            <span class="login100-form-title p-b-29">
                {{  __('messages.Register') }}
            </span>
            <div class="wrap-input100 validate-input m-b-8" data-validate = "Name is reauired">
                <span class="label-input100">{{ __('messages.Name') }}</span>
                <input class="input100" type="text" name="name" id="name" placeholder="{{ __('messages.Type your') }} {{ __('messages.Name') }}"  value="{{ old('name') }}" autofocus>
                <span class="focus-input100" data-symbol="&#xf206;"></span>
            </div>
            <div class="p-b-15 text-center">
                @error('name')
                    <p role="alert" class="error-message">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror
                <p role="alert" class="error-message">
                        <strong id="errorName"></strong>
                    </p>
            </div>

            <div class="wrap-input100 validate-input m-b-8" data-validate = "Email is reauired">
                <span class="label-input100">{{  __('messages.E-Mail Address') }}</span>
                <input class="input100" type="text" name="email" id="email" placeholder="{{ __('messages.Type your') }} {{ __('messages.E-Mail Address') }}"  value="{{ old('email') }}">
                <span class="focus-input100" data-symbol="&#xf206;"></span>
            </div>
            <div class="p-b-15 text-center">
                @error('email')
                    <p role="alert" class="error-message">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror
                <p role="alert" class="error-message">
                        <strong id="errorEmail"></strong>
                    </p>
            </div>
            
            <!-- <div class="wrap-input100 validate-input m-b-8" data-validate = "Phone number is reauired">
                <span class="label-input100">Phone</span>
                <input class="input100" type="text" name="phone" id="phone" placeholder="Type your phone number"  value="{{ old('phone') }}" autofocus>
                <span class="focus-input100" data-symbol="&#xf2b6;"></span>
            </div>
            <div class="p-b-15 text-center">
                @error('phone')
                    <p role="alert" class="error-message">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror
            </div> -->

            <div class="wrap-input100 validate-input p-b-8" data-validate="Password is required">
                <span class="label-input100">{{  __('messages.Password') }}</span>
                <input class="input100" type="password" name="password" id="password" placeholder="{{ __('messages.Type your') }} {{ __('messages.Password') }}"  value="{{ old('password') }}">
                <span class="focus-input100" data-symbol="&#xf190;"></span>
            </div>
            <div class="p-b-15 text-center">
                    <p role="alert" class="error-message">
                        <strong id="errorPassword"></strong>
                    </p>
            </div>

            <div class="wrap-input100 validate-input" data-validate="Password is required">
                <span class="label-input100">{{  __('messages.Confirm Password') }}</span>
                <input class="input100" type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('messages.Confirm Password') }}"  value="{{ old('password_confirmation') }}">
                <span class="focus-input100" data-symbol="&#xf190;"></span>
            </div>
            <div class="p-b-15 text-center">
                    <p role="alert" class="error-message">
                        <strong id="errorConfirmPassword"></strong>
                    </p>
            </div>
            
            <div class="remember p-t-25 p-b-16">
                <div class="contact100-form-checkbox">
                    <input class="input-checkbox100" id="agreement" type="checkbox" name="agreement" {{ old('agreement') ? 'checked' : '' }}>
                    <label class="label-checkbox100" for="agreement" id="agreementCheck">
                        {{  __('messages.I agree to the') }} <a href="{{ route('showTerms') }}" target="_blank" class="termsLabel">{{  __('messages.terms') }}</a> {{  __('messages.and') }} <a  class="termsLabel" target="_blank" href="{{ route('showConditions') }}">{{  __('messages.conditions') }}</a>.
                    </label>
                </div>
            </div>

            <div class="container-login100-form-btn">
                <div class="wrap-login100-form-btn">
                    <div class="login100-form-bgbtn"></div>
                    <button class="login100-form-btn" type="submit" id="registerBtn">
                        {{  __('messages.Register') }}
                    </button>
                </div>
            </div>
            
            <div class="txt1 text-center p-t-34 p-b-20">
                <span>
                    {{  __('messages.Or Register Using') }}
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

            <div class="flex-col-c p-t-25">
                <a href="{{ route('login') }}" class="txt2">
                    {{  __('messages.Login') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('jscontent')
<script>
    $("#registerBtn").click(function(e){
        console.log($('#password_confirmation').val());
        e.preventDefault();
        
        if($('#name').val().length == 0)
        {
            $('#errorName').text('The name is required.');
        }
        else{
            $('#errorName').text('');
        }

        if($('#email').val().length == 0)
        {
            $('#errorEmail').text('The email is required.');
        }
        else{
            $('#errorEmail').text('');
        }

        if($('#password').val().length == 0)
        {
            $('#errorPassword').text('The password is required.');
        }
        else if($('#password').val().length < 8)
        {
            $('#errorPassword').text('The password must be at least 8 characters.');
        }
        else{
            $('#errorPassword').text('');
        }

        if($('#password').val() == $('#password_confirmation').val())
        {
            $('#errorConfirmPassword').text('');
        }
        else
        {
            $('#errorConfirmPassword').text('The confirm password must be same as password.');
        }
        
        if($('#agreement').is(":checked"))
        {
            $('#agreementCheck').css('color', '#212529');
            $('#agreementCheck').css('border-bottom-width', '0px');
        }
        else
        {
            $('#agreementCheck').css('color', 'red');
            $('#agreementCheck').css('border-bottom-color', 'red');
            $('#agreementCheck').css('border-bottom-width', '1px');
            $('#agreementCheck').css('border-bottom-style', 'solid');
        }
        if($('#password').val() == $('#password_confirmation').val() && $('#password').val().length > 7 && $('#agreement').is(":checked")
         && $('#name').val().length && $('#email').val().length)
            $('#registerForm').submit();
    });
    $("#agreement").change(function(e){
        if($('#agreement').is(":checked"))
        {
            $('#agreementCheck').css('color', '#212529');
            $('#agreementCheck').css('border-bottom-width', '0px');
        }
    });
</script>
@endsection

<!-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
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
                                    {{ __('Register') }}
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
