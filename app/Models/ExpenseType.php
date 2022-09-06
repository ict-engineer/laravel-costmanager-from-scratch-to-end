<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    //
    protected $table = 'expensetypes';

    protected $fillable = [
        'name', 'client_id',
    ];

    public function client()
    {
    	return $this->belongsTo('App\Models\Client');
    }
}
