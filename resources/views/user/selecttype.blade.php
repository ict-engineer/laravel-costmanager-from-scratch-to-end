@extends('layouts.sign')

@section('title')
Select User Type
@endsection

@section('contentcss')
<style>
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
    .signup-btn:hover {
        background-color: rgba(255, 255, 255, 1);
    }
</style>
@endsection

@section('content')
<div class="container-login100">
<div>
    <div class="wrap-login100 p-l-35 p-r-35 p-t-45 p-b-44">
        <span class="login100-form-logo">
            <img width="100" src="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}"></img>
        </span>
        <span class="login100-form-title p-b-39">
            {{ __('messages.Select UserType') }}
        </span>

        <div class="container-login100-form-btn p-b-15">
            <div class="wrap-login100-form-btn" style="border-radius: 35px;">
                <div class="login100-form-bgbtn"></div>
                <button class="login100-form-btn" id="btnClient" style="padding: 15px 30px;height: 70px;">
                    {{ __('messages.If you want to enter as a Contractor, please click here.') }}
                </button>
            </div>
        </div>

        <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn" style="border-radius: 35px;">
                <div class="login100-form-bgbtn"></div>
                <button class="login100-form-btn" id="btnProvider" style="padding: 15px 30px;height: 70px;">
                    {{ __('messages.In case you want to enter as a supplier of materials, click here.') }}
                </button>
            </div>
        </div>
        
        
        <form id="sendForm" style="display:none;" method="POST" action="{{ route('user.setUserType') }}">
            @csrf
            <input type="hidden" name="usertype" id="usertype">
        </form>
    </div>
    <div class="mt-2" style="display:flex;justify-content:center;">
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
</div>
@endsection
@section('jscontent')
<script>
    $(document).ready(function () {
        $("body").on("click","#btnProvider",function(){
            $('#usertype').val('Provider');
            $('#sendForm').submit();
        });
        $("body").on("click","#btnClient",function(){
            $('#usertype').val('Client');
            $('#sendForm').submit();
        });
    });
</script>
@endsection