<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = 'transactions';

    protected $fillable = [
        'transaction_date', 'type', 'currency', 'amount', 'chargeid', 'description', 'client_id',
    ];

    public function client()
    {
    	return $this->belongsTo('App\Models\Client');
    }
}
