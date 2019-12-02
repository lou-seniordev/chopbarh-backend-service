<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TranPlayer;

class TranPlayerController extends Controller
{
    public function index()
    {
        //
        return datatables()->collection(TranPlayer::all())->toJson();
    }
}
