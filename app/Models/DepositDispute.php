<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositDispute extends Model
{
    //
    public $fillable = [
        "amount", "channel", "customer_id", "deposit_date", "gateway", "playerId", "transaction_reference"
    ];
}
