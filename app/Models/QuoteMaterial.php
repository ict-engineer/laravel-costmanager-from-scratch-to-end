<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteMaterial extends Model
{
    //
    protected $table = 'quotematerials';

    protected $fillable = [
        'material_id', 'quantity', 'quote_item_id', 'isMine', 'description', 'price', 'provider',
    ];

    public function quoteitem()
    {
    	return $this->belongsTo('App\Models\QuoteItem');
    }
}
