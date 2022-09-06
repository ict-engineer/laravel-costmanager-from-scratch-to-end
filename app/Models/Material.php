<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //
    protected $fillable = [
        'description', 'brand', 'sku', 'image', 'shop_id', 'partno', 'price',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }
}
