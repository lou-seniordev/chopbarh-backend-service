<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    public $fillable = [
        'amount', 'channel', 'customer_id', 'withdrawal_date', 'gameTransactionId',
        'paid_at', 'playerId', 'status', 'transaction_fees', 'transaction_reference'
    ];
}