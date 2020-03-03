<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperAgent extends Model
{
    //
    public $fillable = [
        'email', 'first_name', 'last_name', 'phone_number', 'gender', 'DOB', 'state',
        'address', 'alternate_phone', 'city', 'status', 'type', 'description',
    ];
}
