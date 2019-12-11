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
        if (sizeof(explode('-', $value)) > 1)
            $this->attributes['DOB'] = Carbon::createFromFormat('d-m-Y', $value);
        else
            $this->attributes['DOB'] = Carbon::createFromFormat('d/m/Y', $value);
    }
}
