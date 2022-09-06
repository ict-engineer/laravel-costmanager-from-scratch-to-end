<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Billable;
use Mail;
use URL;

class User extends Authenticatable  implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    use Billable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'usertype', 'isdelete', 'logoimage', 'image', 'google_id', 'facebook_id',
    ];

    protected $appends = [ 'custom' ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //1:1 with provider
    public function provider()
    {
        return $this->hasOne('App\Provider');
    }
    
    public function employee()
    {
        return $this->hasOne('App\Models\Employee');
    }


    //1:1 with client
    public function client()
    {
        return $this->hasOne('App\Models\Client');
    }

    public static function sendWelcomeEmail($user)
    {
      // Generate a new reset password token
      $token = app('auth.password.broker')->createToken($user);
      $names = explode(' ', $user->name);
      $sendernames = explode(' ', Auth::user()->name);
      $firstName = $names[0];
      // Send email
      Mail::send('auth.passwords.resetmail', ['user' => $user, 'token' => $token, 'name' => $firstName, 'sendername' => $sendernames[0], 'url' => URL::to('/')], function ($m) use ($user) {
        $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

        $m->to($user->email, $user->name)->subject('Welcome to our website.');
      });
    }

    public static function sendPurchaseSuccessEmail()
    {
        $user = Auth::user();
        Mail::send('user.client.purchase.purchase_success', ['userName' => $user->name, 'date' => date('M d,Y', strtotime("+1 months", strtotime(date('Y-M-d')))), 'url' => URL::to('/')], function ($m) use ($user) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
    
            $m->to($user->email, $user->name)->subject('Thanks!');
        });
    }

    public static function sendQuoteByEmail($data, $name, $url)
    {
        $sendernames = explode(' ', Auth::user()->name);
        $senderemail = Auth::user()->email;
        $senderFirstName = $sendernames[0];
        Mail::send('user.client.cquote.quote_mail', ['from' => $data->from, 'firstName' => $name, 'to' => $data->to, 'subject' => $data->subject, 'text' => $data->message, 'url' => URL::to($url)], function ($m) use ($data, $senderemail, $senderFirstName) {
            $m->from($senderemail, $senderFirstName);
            
            $m->to($data->to)->subject($data->subject);
        });
    }
}
