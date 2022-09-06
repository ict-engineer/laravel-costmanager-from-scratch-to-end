<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteService extends Model
{
    //
    protected $table = 'quoteservices';

    protected $fillable = [
        'name', 'provider', 'cquote_id', 'utility', 'cost', 'price', 'cservice_id',
    ];

    public function cquote()
    {
    	return $this->belongsTo('App\Models\CQuote');
    }
}
