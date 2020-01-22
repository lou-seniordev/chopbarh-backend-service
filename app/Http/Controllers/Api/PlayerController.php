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
                $statusCode = Response::HTTP_NOT_FOUND;
            }

        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }

    public function edit(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'full_name' => 'required',
                'dob' => 'required',
                'sex' => 'required',
                'email' => 'required|email',
            ]);

            $response = $this->editPlayer($request->input('full_name'), $request->input('dob'), $request->input('sex'), $request->input('email'));

            if ($response) {
                $result['status'] = true;
                $result['message'] = "Profile was successfully updated";
            } else {
                $result['status'] = false;
                $result['message'] = "Action was not carried out due to an error";

                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            }

        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }

    public function change_pin(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'old_pin' => 'required',
                'new_pin' => 'required'
            ]);

            $response = $this->changePlayerPin($request->input('old_pin'), $request->input('new_pin'));

            if ($response) {
                $result['status'] = true;
                $result['message'] = "Pin was successfully changed";
            } else {
                $result['status'] = false;
                $result['message'] = "Action was not carried out due to an error";

                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            }

        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }

    public function login(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'phone_number' => 'required',
                'pin' => 'required'
            ]);

            $response = $this->loginPlayer($request->input('phone_number'), $request->input('pin'));

            if (isset($response->error)) {
                $result['status'] = false;
                $result['message'] = "Request was not processed due to an error";

                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            } else {
                $result['status'] = true;
                $result['data']['authToken'] = $response->authToken;
                $result['data']['userId'] = $response->userId;
            }

        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }

    public function update_coin(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'amount' => 'required|numeric',
                'playerId' => 'required',
                'condition' => 'required|in:0,1'
            ]);

            $response = $this->updatePlayerCoin($request->input('amount'), $request->input('playerId'), $request->input('condition'));

            if (isset($response->error)) {
                $result['status'] = false;
                $result['message'] = "Request was not processed due to an error";

                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            } else {
                $result['status'] = true;
                $result['data'] = $response->scriptData->Result;
            }
        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }

    public function update_cash(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'amount' => 'required|numeric',
                'playerId' => 'required',
                'condition' => 'required|in:0,2'
            ]);

            $response = $this->updatePlayerCash($request->input('amount'), $request->input('playerId'), $request->input('condition'));

            if (isset($response->error)) {
                $result['status'] = false;
                $result['message'] = "Request was not processed due to an error";

                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            } else {
                $result['status'] = true;
                $result['data'] = $response->scriptData->Result;
            }
        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }
}
