<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranPlayer extends Model
{
    //
    public $timestamps = false;

    public $fillable = [
        'ID', 'TranID', 'PlayerID', 'Target', 'AMOUNT', 'Coins', 'Mode', 'Cashs', 'TimeStamp'
    ];
}
