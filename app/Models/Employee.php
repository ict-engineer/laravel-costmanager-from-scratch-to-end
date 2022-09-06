<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $fillable = [
        'name', 'phone', 'salary', 'cycle', 'client_id', 'user_id', 'image', 'role',
    ];

    //1:1 with user
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function client()
    {
    	return $this->belongsTo('App\Models\Client');
    }
}
