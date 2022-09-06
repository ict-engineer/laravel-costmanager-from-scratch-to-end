<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'country', 'name', 'description', 'numberofusers', 'currency', 'price', 'stripe_id', 'stripeprice_id',
    ];
}
