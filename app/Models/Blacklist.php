<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    //
    public $fillable = [
        'account_number', 'time'
    ];

    public static function isBlocked($account_number) {
        $count = self::where('account_number', $account_number)->count();

        return $count > 0 ? true : false;
    }
}
