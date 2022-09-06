<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteEmployee extends Model
{
    //
    protected $table = 'quoteemployees';

    protected $fillable = [
        'name', 'cquote_id', 'hours', 'cost', 'total', 'employee_id',
    ];

    public function cquote()
    {
    	return $this->belongsTo('App\Models\CQuote');
    }
}
