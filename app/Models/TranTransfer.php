<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranTransfer extends Model
{
    //
    public $timestamps = false;

    public $fillable = [
        'TranID', 'TranType', 'TranTime', 'TRANSFER_TYPE', 'TRANSFER_AMOUNT', 'TRANSFER_FROM', 'TRANSFER_TO'
    ];
}
