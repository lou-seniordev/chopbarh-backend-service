<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 27.11.19
 * Time: 05:39
 */

namespace App\Http\Controllers;


use App\Http\Controllers\Cron\CronJob;

class TranPlayerController extends Controller
{
    use CronJob;

    public function fetchFromGameSpark()
    {
        $result = $this->fetchTranPlayerList();
        return response()->json($result);
    }
}