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
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function get($playerId, Request $request) {
        $pageSize = 15;

        if ($request->has('pageSize')) {
            $pageSize = $request->pageSize;
        }
        $pagedData = Withdrawal::where('playerId', $playerId)->paginate($pageSize);

        return response()->json($pagedData);
    }

    public function update(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $withdrawal = Withdrawal::where('transaction_reference', $request->transaction_reference)->firstOrFail();

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
                    'transaction_reference' => 'required|unique:withdrawals,transaction_reference,'.$withdrawal->id.',id'
                ]);

                if ($withdrawal->update($request->all())) {
                    $result['status'] = true;
                    $result['message'] = "Withdrawal successfully update";
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
        } catch (ModelNotFoundException $e) {
            $result['status'] = false;
            $result['message'] = "Not found";
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return response()->json($result, $statusCode);
    }

    public function delete(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $deposit = Withdrawal::where('transaction_reference', $request->transaction_reference)->firstOrFail();

            $deposit->delete();

            $result['status'] = true;
            $result['message'] = "Withdrawal successfully deleted";
        } catch (ModelNotFoundException $e) {
            $result['status'] = false;
            $result['message'] = "Not found";
            $statusCode = Response::HTTP_NOT_FOUND;
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
                'account_number' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $isBlocked = Blacklist::isBlocked($value);

                        if ($isBlocked)
                            $fail($attribute.' is in the blacklist');
                    }
                ],
                'playerId' => 'required',
                'bank' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if ($value == "090175")
                            $fail($attribute.' must be different with 090175');
                    }
                ]
            ]);

            $response = $this->chopbarhWidthraw($request->all());

            if (isset($response->status) and $response->status) {
                $result = $response;
            } else {
                $result = $response;
                $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            }
        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }
}