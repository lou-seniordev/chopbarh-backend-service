<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 17.12.19
 * Time: 19:12
 */

namespace App\Http\Controllers\Api;

use App\Models\LiaisonAgent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LiaisonAgentController extends Controller
{

    public function register(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:liaison_agents',
                'gender' => 'required',
                'phone_number' => 'required',
                'dob' => 'required',
                'state' => 'required'
            ]);

            $liaisonAgent = new LiaisonAgent();
            $liaisonAgent->fill($request->all());
            $liaisonAgent->setGeneratedPasswordAttribute();
            $liaisonAgent->setTokenAttribute();
            $liaisonAgent->save();

            $result['status'] = true;
            $result['data'] = $liaisonAgent;
            $result['message'] = "Liaison Agent successfully created";
        } catch (ValidationException $exception) {
            $result['success'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }

    public function registerChild($token, Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $parent = LiaisonAgent::where('token', $token)->firstOrFail();
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:liaison_agents',
                'gender' => 'required',
                'phone_number' => 'required',
                'dob' => 'required',
                'state' => 'required'
            ]);

            $liaisonAgent = new LiaisonAgent();
            $liaisonAgent->fill($request->all());
            $liaisonAgent->parent = $parent->token;
            $liaisonAgent->setGeneratedPasswordAttribute();
            $liaisonAgent->setTokenAttribute();
            $liaisonAgent->save();

            $result['status'] = true;
            $result['data'] = $liaisonAgent;
            $result['message'] = "Liaison Agent successfully created";
        } catch (ValidationException $exception) {
            $result['success'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        } catch (ModelNotFoundException $exception) {
            $result['success'] = false;
            $result['message'] = "Could not find parent agent";
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($result, $statusCode);
    }

    public function list() {
        $result = array();

        $result['status'] = true;
        $result['data'] = LiaisonAgent::with(['child_agents', 'parent_agent'])->get();

        return response()->json($result);
    }
}