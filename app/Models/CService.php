<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CService extends Model
{
    //
    protected $table = 'cservices';

    protected $fillable = [
        'name', 'provider', 'cost', 'utility', 'price', 'client_id',
    ];
}
