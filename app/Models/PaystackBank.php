<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaystackBank extends Model
{
    //
    public $fillable = [
        "auth_code", "account_number", "bank", "bank_code", "last_digits", "playerId"
    ];
}
