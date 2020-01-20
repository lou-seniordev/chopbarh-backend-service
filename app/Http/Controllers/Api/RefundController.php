<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 20.01.20
 * Time: 17:19
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Validation\ValidationException;

class RefundController extends Controller
{
    public function add(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'amount' => 'required|numeric',
                'bank' => 'required',
                'customer_id' => 'required',
                'refund_date' => 'required',
                'gameTransactionId' => 'required',
                'paid_at' => 'required|numeric',
                'playerId' => 'required',
                'status' => 'required',
                'transaction_reference' => 'required'
            ]);

            $deposit = new Refund();
            $deposit->fill($request->all());
            if ($deposit->save()) {
                $result['status'] = true;
                $result['message'] = "Refund successfully recorded";
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