<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaveCard extends Model
{
    //
    public $fillable = [
        "auth_code", "card_type", "email", "expiry", "last_digits", "playerId"
    ];
}
