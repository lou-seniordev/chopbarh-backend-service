<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranGame extends Model
{
    //
    public $timestamps = false;

    public $fillable = [
        'TranID', 'TranType', 'TranTime', 'GAME_NAME', 'GAME_TYPE', 'GAME_PLAYERS', 'GAME_TOTAL_REVENUE',
        'GAME_WIN_AMOUNTS', 'GAME_ENTRY_FEE', 'GAME_CHECK_AMOUNTS', 'GAME_START', 'GAME_END'
    ];
}
