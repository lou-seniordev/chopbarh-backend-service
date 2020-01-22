<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 20.01.20
 * Time: 17:19
 */

namespace App\Http\Controllers\Api;

use App\Models\Deposit;

use App\Http\Controllers\Controller;
use App\Models\PaymentAccount;
use App\Models\WithdrawalAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function add_payment(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'account_number' => 'required|unique:payment_accounts',
                'bank_name' => 'required',
                'playerId' => 'required'
            ]);

            $account = new PaymentAccount();
            $account->fill($request->all());
            if ($account->save()) {
                $result['status'] = true;
                $result['message'] = "Account successfully added";
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

    public function add_withdrawal(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'account_number' => 'required|unique:withdrawal_accounts',
                'bank_name' => 'required',
                'bank_code' => 'required',
                'playerId' => 'required'
            ]);

            $account = new WithdrawalAccount();
            $account->fill($request->all());
            if ($account->save()) {
                $result['status'] = true;
                $result['message'] = "Account successfully recorded";
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
}