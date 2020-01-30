<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\GameSpark;
use App\Models\TranGame;
use App\Models\TranTransfer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\ValidationException;
use DB;

class TransactionController extends Controller
{
    use GameSpark;

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

        $query = TranGame::query();

        if ($request->has('start') && $request->has('end')) {
            $start = strtotime($request->start . " 00:00:00") * 1000;
            $end = strtotime($request->end . "23:59:59") * 1000;

            $query = $query->where('GAME_START', '>', $start)->where('GAME_START', '<', $end);
        }

        $totalGamesQuery = clone $query;
        $totalGames = $totalGamesQuery->where('GAME_TYPE', 'NORMAL')->count();

        $totalTournamentsQuery = clone $query;
        $totalTournaments = $totalTournamentsQuery->where('GAME_TYPE', 'TOURNAMENT')->count();

        $totalGameRevenuesQuery = clone $query;
        $totalGameRevenues = $totalGameRevenuesQuery->sum('GAME_TOTAL_REVENUE');

        $totalStakeQuery = clone $query;
        $totalStake = $totalStakeQuery->get([DB::raw("SUM((LENGTH(GAME_PLAYERS) - LENGTH(REPLACE(GAME_PLAYERS, '/', '')) + 1) * GAME_ENTRY_FEE) as TotalStake")]);

        $paginate = $query->paginate($pageSize);

        $custom = collect([
            'totalStake' => $totalStake[0]->TotalStake,
            'totalGames' => $totalGames,
            'totalTournaments' => $totalTournaments,
            'totalGameRevenues' => $totalGameRevenues
        ]);

        $data = $custom->merge($paginate);

        return response()->json($data);

        /*
        return response()->json([
            'amountGamePlayed' => $count,
            'start' => $start,
            'end' => $end
        ]);
        */
    }

    public function transfer_agent(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'amount' => 'required|numeric|max:20000',
                'phone_number' => 'required',
                'playerId' => 'required',
                'transaction_reference' => 'required'
            ]);

            $response = $this->transferAgent($request->input('amount'), $request->input('phone_number'), $request->input('playerId'), $request->input('transaction_reference'));

            if (isset($response->error)) {
                $result['status'] = false;
                $result['message'] = $response->error->Error;

                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            } else {
                $result['status'] = true;
                $result['message'] = "Transaction was successful";
            }
        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }
}
