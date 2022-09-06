<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Lang;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'exists:users,' . $this->username() . ',isdelete,0',
            'password' => 'required|string',
        ], [
            $this->username() . '.exists' => Lang::get('messages.The selected email is invalid or the account has been disabled.')
        ]);
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        if(Auth::user()->hasPermissionTo('Access Admin'))
        {
            return 'dashboard';
        }
        else
        {
            return '/welcome';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
