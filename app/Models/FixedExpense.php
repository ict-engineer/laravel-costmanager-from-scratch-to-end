<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedExpense extends Model
{
    //
    protected $table = 'fixedexpenses';

    protected $fillable = [
        'name', 'cost', 'cycle', 'client_id',
    ];

    public function client()
    {
    	return $this->belongsTo('App\Models\Client');
    }
}
