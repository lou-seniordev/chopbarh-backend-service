<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalAccount extends Model
{
    //
    public $fillable = [
        "account_number", "bank_name", "bank_code", "playerId"
    ];
}
