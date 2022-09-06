<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = [
        'companyname', 'addline1', 'country', 'cp', 'numberofemployees', 'service', 'payment', 'user_id', 'payment_date', 'stripe_id', 'card_brand', 'card_last_four', 'lat', 'lng',
    ];

    public function setServiceAttribute($value)
    {
        $this->attributes['service'] = json_encode($value);
    }
  
    /**
     * Get the categories
     *
     */
    public function getServiceAttribute($value)
    {
        return $this->attributes['service'] = json_decode($value);
    }

    //1:1 with user
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function employees()
    {
        return $this->hasMany('App\Models\Employee');
    }   

    public function subscriptions()
    {
        return $this->hasMany('App\Models\Subscription');
    }   

    public function expensetypes()
    {
        return $this->hasMany('App\Models\ExpenseType');
    }   

    public function fixedexpenses()
    {
        return $this->hasMany('App\Models\FixedExpense');
    }
    
    public function cclients()
    {
        return $this->hasMany('App\Models\CClient');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function cmaterials()
    {
        return $this->hasMany('App\Models\CMaterial');
    }
}
