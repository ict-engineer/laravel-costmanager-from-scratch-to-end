<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicQuote extends Model
{
    //
    protected $table = 'public_quotes';

    protected $fillable = [
        'name', 'quote_id', 'showMaterial', 'showService', 'showEmployee', 'showOnlyTotal', 'content',
    ];
}
