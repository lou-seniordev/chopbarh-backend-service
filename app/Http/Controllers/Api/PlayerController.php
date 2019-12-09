<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;

class PlayerController extends Controller
{
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
}
