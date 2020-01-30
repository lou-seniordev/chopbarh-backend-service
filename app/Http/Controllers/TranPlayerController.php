<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 27.11.19
 * Time: 05:39
 */

namespace App\Http\Controllers;


use App\Http\Controllers\Traits\GameSpark;

class TranPlayerController extends Controller
{
    use GameSpark;

    public function fetchFromGameSpark()
    {
        $result = $this->fetchTranPlayerList();
        return response()->json($result);
    }
}