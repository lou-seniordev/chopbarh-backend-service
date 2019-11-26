<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    //
    public $fillable = [
        'PlayerID', 'CreatedTime', 'Email', 'CBCoins', 'DeviceID', 'SEX', 'PlayerStatus', 'RealCoins', 'NickName',
        'LastTimeStamp', 'PhoneNum', 'DOB', 'FullName', 'ImageID', 'TotalWinning'
    ];

    public $timestamps = false;

    public function setDOBAttribute($value) {
        $this->attributes['DOB'] = Carbon::createFromFormat('d/m/Y', $value);
    }
}
