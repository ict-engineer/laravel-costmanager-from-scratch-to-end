<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteGroup extends Model
{
    //
    protected $table = 'quotegroups';

    protected $fillable = [
        'name', 'cquote_id', 'color',
    ];

    
    public function cquote()
    {
    	return $this->belongsTo('App\Models\CQuote');
    }

    public function quoteitems()
    {
        return $this->hasMany('App\Models\QuoteItem');
    }
   
}
