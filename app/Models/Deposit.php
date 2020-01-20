<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    public $fillable = [
        'amount', 'channel', 'customer_id', 'deposit_date', 'gameTransactionId', 'gateway',
        'paid_at', 'playerId', 'refId', 'status', 'transaction_fees', 'transaction_reference'
    ];
}
