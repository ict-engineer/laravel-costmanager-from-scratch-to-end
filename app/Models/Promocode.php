<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    //
    protected $table = 'promocodes';

    protected $fillable = [
        'name', 'code', 'discount', 'duration', 'active',
    ];
}
