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

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Pagination\Paginator;

use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DepositController extends Controller
{
    public function add(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'amount' => 'required|numeric',
                'channel' => 'required',
                'customer_id' => 'required',
                'deposit_date' => 'required',
                'gateway' => 'required',
                'paid_at' => 'required|numeric',
                'playerId' => 'required',
                'refId' => 'required|unique:deposits',
                'status' => 'required',
                'transaction_fees' => 'required|numeric',
                'transaction_reference' => 'unique:deposits'
            ]);

            $deposit = new Deposit();
            $deposit->fill($request->all());
            if ($deposit->save()) {
                $result['status'] = true;
                $result['message'] = "Deposit successfully recorded";
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
        $pagedData = Deposit::where('playerId', $playerId)->paginate($pageSize);

        return response()->json($pagedData);
    }

    public function update(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $deposit = Deposit::where('refId', $request->refId)->firstOrFail();

            try {
                $request->validate([
                    'refId' => 'required',
                    'transaction_reference' => 'unique:deposits,transaction_reference,'.$deposit->id.',id'
                ]);

                if ($deposit->update($request->all())) {
                    $result['status'] = true;
                    $result['message'] = "Deposit successfully update";
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
            $deposit = Deposit::where('refId', $request->refId)->firstOrFail();

            $deposit->delete();

            $result['status'] = true;
            $result['message'] = "Deposit successfully deleted";
        } catch (ModelNotFoundException $e) {
            $result['status'] = false;
            $result['message'] = "Not found";
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return response()->json($result, $statusCode);
    }
}