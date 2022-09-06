<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\User;

class FacebookController extends Controller
{
    //
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }
      
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {
    
            $user = Socialite::driver('facebook')->stateless()->user();
     
            $finduser = User::where('facebook_id', $user->id)->first();
     
            if($finduser){
     
                Auth::login($finduser);
    
                return redirect('/');
     
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
                    'password' => md5(rand(1,10000)),
                    'isdelete' => 0,
                ]);
                $newUser->email_verified_at = date('Y-m-d H:i:s');
                $newUser->update();
                Auth::login($newUser);
     
                return redirect('/');
            }
    
        } catch (Exception $e) {
            dd($e);
        }
    }
}
