<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
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
        try {
            $this->attributes['DOB'] = Carbon::createFromFormat('d/m/Y', $value);
        } catch (Exception $e) {
            try {
                $this->attributes['DOB'] = Carbon::createFromFormat('d-m-Y', $value);
            } catch (Exception $e) {
                $this->attributes['DOB'] = Carbon::createFromFormat('Y-m-d', $value);
            }
        }
    }
}
