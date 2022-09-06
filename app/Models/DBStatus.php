<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DBStatus extends Model
{
    //
    protected $table = 'db_status';

    protected $fillable = [
        'str_key', 'str_value',
    ];
}
