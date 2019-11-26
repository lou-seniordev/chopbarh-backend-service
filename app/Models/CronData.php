<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronData extends Model
{
    //
    public $fillable = [
        'lastID'
    ];

    public $timestamps = false;
}
