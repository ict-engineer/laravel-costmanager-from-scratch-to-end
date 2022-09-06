<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    //name
    protected $table = 'quoteitems';

    protected $fillable = [
        'name', 'quantity', 'cost', 'utility', 'total', 'quote_group_id',
    ];

    public function quotegroup()
    {
    	return $this->belongsTo('App\Models\QuoteGroup');
    }

    public function quotematerials()
    {
        return $this->hasMany('App\Models\QuoteMaterial');
    }
}
