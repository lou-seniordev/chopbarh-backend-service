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

use App\Models\DepositDispute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Traits\CloudFunction;

class DepositController extends Controller
{
    use CloudFunction;

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
                'refId' => 'required',
                'status' => 'required',
                'transaction_fees' => 'required|numeric',
                /*'transaction_reference' => 'unique:deposits'*/
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

    public function deposit(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'token' => 'required',
                'amount' => 'required|numeric|max:50000',
                'phone_number' => 'required',
                'email' => 'required|email',
                'reference' => 'required',
                'playerId' => 'required'
            ]);

            $response = $this->chopbarhDeposit($request->all());

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

    public function search(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'refId' => 'required'
            ]);

            $deposit = Deposit::where('refId', $request->input('refId'))->firstOrFail();

            $result['status'] = true;
            $result['data'] = $deposit;
        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        } catch (ModelNotFoundException $exception) {
            $result['status'] = false;
            $result['message'] = "Service could not be reached";
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return response()->json($result, $statusCode);
    }

    public function dispute(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'amount' => 'required|numeric',
                'channel' => 'required',
                'customer_id' => 'required',
                'deposit_date' => 'required',
                'gateway' => 'required',
                'playerId' => 'required',
                'transaction_reference' => 'unique:deposit_disputes'
            ]);

            $dispute = new DepositDispute();
            $dispute->fill($request->all());
            if ($dispute->save()) {
                $result['status'] = true;
                $result['message'] = "Action was successful";
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