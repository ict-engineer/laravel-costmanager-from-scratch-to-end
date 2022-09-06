<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteComment extends Model
{
    //
    protected $table = 'quotecomments';

    protected $fillable = [
        'cquote_id', 'content', 'isQuote',
    ];

    
    public function cquote()
    {
    	return $this->belongsTo('App\Models\CQuote');
    }
}
