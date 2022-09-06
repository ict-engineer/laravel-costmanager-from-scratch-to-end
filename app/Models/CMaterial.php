<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMaterial extends Model
{
    //
    protected $table = 'cmaterials';
    protected $fillable = [
        'provider', 'description', 'price', 'image', 'client_id', 'brand', 'partno', 'sku',
    ];

    public function client()
    {
    	return $this->belongsTo('App\Models\Client');
    }
}
