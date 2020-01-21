<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaystackCard extends Model
{
    //
    public $fillable = [
        "auth_code", "card_type", "cvv", "expiry_month", "expiry_year", "last_digits", "playerId"
    ];
}
