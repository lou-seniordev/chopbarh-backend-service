<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 20.01.20
 * Time: 17:19
 */

namespace App\Http\Controllers\Api;

use App\Models\PaystackBank;
use App\Models\PaystackCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Validation\ValidationException;

class PaystackController extends Controller
{
    public function add_card(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'auth_code' => 'required',
                'card_type' => 'required',
                'cvv' => 'required',
                'expiry_month' => 'required',
                'expiry_year' => 'required',
                'last_digits' => 'required',
                'playerId' => 'required'
            ]);

            $card = new PaystackCard();
            $card->fill($request->all());
            if ($card->save()) {
                $result['status'] = true;
                $result['message'] = "Card successfully added";
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

    public function add_bank(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'auth_code' => 'required',
                'account_number' => 'required',
                'bank' => 'required',
                'bank_code' => 'required',
                'last_digits' => 'required',
                'playerId' => 'required'
            ]);

            $bank = new PaystackBank();
            $bank->fill($request->all());
            if ($bank->save()) {
                $result['status'] = true;
                $result['message'] = "Bank token successfully added";
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