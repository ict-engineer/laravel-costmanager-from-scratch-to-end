<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = 'projects';

    protected $fillable = [
        'name', 'client', 'cclient_id',
    ];

    public function cclient()
    {
    	return $this->belongsTo('App\Models\CClient');
    }

    public function cquotes()
    {
        return $this->hasMany('App\Models\CQuote');
    }
}
