<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundDispute extends Model
{
    //
    public $fillable = [
        "amount", "bank", "customer_id", "refund_date", "gameTransactionId", "gateway", "playerId", "transaction_reference", "status"
    ];
}
