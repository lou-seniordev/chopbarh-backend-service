<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TranGame;
use App\Models\TranTransfer;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

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
        $page = $request->has('page') ? $request->page : 1;
        $pageSize = $request->has('pageSize') ? $request->pageSize : 15;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if ($request->has('start') && $request->has('end')) {
            $start = strtotime($request->start . " 00:00:00") * 1000;
            $end = strtotime($request->end . "23:59:59") * 1000;

            return response()->json(TranGame::where('GAME_START', '>', $start)->where('GAME_START', '<', $end)->paginate($pageSize));
        } else {
            $start = 0; $end = 0;

            return response()->json(TranGame::paginate($pageSize));
        }

        /*
        return response()->json([
            'amountGamePlayed' => $count,
            'start' => $start,
            'end' => $end
        ]);
        */
    }
}
