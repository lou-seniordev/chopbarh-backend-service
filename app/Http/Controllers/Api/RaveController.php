<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 20.01.20
 * Time: 17:19
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RaveCard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Validation\ValidationException;

class RaveController extends Controller
{
    public function add_card(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'auth_code' => 'required|unique:rave_cards',
                'card_type' => 'required',
                'email' => 'required',
                'expiry' => 'required',
                'last_digits' => 'required',
                'playerId' => 'required'
            ]);

            $card = new RaveCard();
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
}