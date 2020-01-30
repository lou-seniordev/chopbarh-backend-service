<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 20.01.20
 * Time: 17:19
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CloudFunction;
use App\Http\Controllers\Traits\GameSpark;
use App\Models\Blacklist;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Validation\ValidationException;

class WithdrawalController extends Controller
{
    use GameSpark;
    use CloudFunction;

    public function add(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'amount' => 'required|numeric',
                'channel' => 'required',
                'customer_id' => 'required',
                'withdrawal_date' => 'required',
                'paid_at' => 'required|numeric',
                'playerId' => 'required',
                'status' => 'required',
                'transaction_fees' => 'required|numeric',
                'transaction_reference' => 'unique:withdrawals'
            ]);

            $deposit = new Withdrawal();
            $deposit->fill($request->all());
            if ($deposit->save()) {
                $result['status'] = true;
                $result['message'] = "Withdrawal successfully recorded";
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

    public function withdraw(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'amount' => 'required|numeric|max:50000',
                'bank_name' => 'required',
                'phone_number' => 'required',
                'account_number' => 'required',
                'playerId' => 'required',
                'bank' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value == "090175")
                            $fail($attribute.' must be different with 090175');
                    }
                ]
            ]);


            $isBlocked = Blacklist::isBlocked($request->input('account_number'));

            if ($isBlocked) {
                $result['status'] = false;
                $result['message'] = "Account is in the blacklist";

                $statusCode = Response::HTTP_FORBIDDEN;
            } else {
                $response = $this->chopbarhWidthraw($request->all());

                if ($response->status) {
                    $result = $response;
                } else {
                    $result = $response;
                    $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                }
            }
        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }
}