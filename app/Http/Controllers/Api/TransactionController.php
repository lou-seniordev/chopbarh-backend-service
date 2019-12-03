<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TranGame;
use App\Models\TranTransfer;
use Illuminate\Http\Request;

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

    public function gamePlayed(Request $request) {
        if ($request->has('start') && $request->has('end')) {
            $start = strtotime($request->start . " 00:00:00") * 1000;
            $end = strtotime($request->end . "23:59:59") * 1000;

            $count = TranGame::where('GAME_START', '>', $start)->where('GAME_START', '<', $end)->count();
        } else {
            $start = 0; $end = 0;

            $count = TranGame::all()->count();
        }

        return response()->json([
            'amountGamePlayed' => $count,
            'start' => $start,
            'end' => $end
        ]);
    }
}
