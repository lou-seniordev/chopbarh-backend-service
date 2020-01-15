<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GameSpark\GameSpark;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PlayerController extends Controller
{
    use GameSpark;

    public function index()
    {
        //
        return datatables()->collection(Player::all())->toJson();
    }

    public function total() {
        $count = Player::all()->count();

        return response()->json([
            'totalRegistered' => $count
        ]);
    }

    public function active() {
        $count = Player::where('PlayerStatus', 1)->count();

        return response()->json([
            'totalRegistered' => $count
        ]);
    }

    public function get(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'phone_number' => 'required'
            ]);

            $player = $this->getPlayer($request->input('phone_number'));

            if (isset($player)) {
                $result['status'] = true;
                $result['data'] = $player;
            } else {
                $result['status'] = false;
                $result['message'] = "Player doesn't exist";
            }

        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }
}
