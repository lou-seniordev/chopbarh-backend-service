<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TranGame;
use App\Models\TranTransfer;

class TransactionController extends Controller
{
    public function game()
    {
        //
        return datatables()->collection(TranGame::all())->toJson();
    }

    public function transfer()
    {
        //
        return datatables()->collection(TranTransfer::all())->toJson();
    }
}
