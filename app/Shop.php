<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    protected $fillable = [
        'name', 'addline1', 'country', 'cp', 'provider_id', 'currency', 'lat', 'lng',
    ];

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
    public function materials()
    {
        return $this->hasMany('App\Models\Material');
    }
    public static function boot() {
        parent::boot();
    
        static::deleting(function($shop) {
            // here you could instantiate each related Comment
            // in this way the boot function in the Comment model will be called
            $shop->materials()->delete();
        });
    } 
}
