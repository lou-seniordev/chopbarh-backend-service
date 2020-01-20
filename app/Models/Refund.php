<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    public $fillable = [
        'amount', 'bank', 'customer_id', 'refund_date', 'gameTransactionId',
        'paid_at', 'playerId', 'status', 'transaction_reference'
    ];
}