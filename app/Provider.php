<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'companyname', 'addline1', 'addline2', 'country', 'cp', 'user_id', 'api_token',
    ];

    public function shops()
    {
        return $this->hasMany('App\Shop');
    }   
    public static function boot() {
        parent::boot();
    
        static::deleting(function($provider) {
            // here you could instantiate each related Comment
            // in this way the boot function in the Comment model will be called
            $provider->shops->each(function($shop) {
                // and then the static::deleting method when you delete each one
                $shop->delete();
            });
        });
    } 

    //1:1 with user
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
