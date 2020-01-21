<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    //
    public $fillable = [
        "account_number", "bank_name", "playerId"
    ];
}
