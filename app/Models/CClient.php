<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CClient extends Model
{
    //
    protected $table = 'cclients';

    protected $fillable = [
        'name', 'companyname', 'phone', 'email', 'client_id', 'addline',
    ];

    public function client()
    {
    	return $this->belongsTo('App\Models\Client');
    }

    public function projects()
    {
        return $this->hasMany('App\Models\Project');
    }
}
