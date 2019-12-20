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
            $result['status'] = false;
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
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        } catch (ModelNotFoundException $exception) {
            $result['status'] = false;
            $result['message'] = "Could not find parent agent";
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
                'password' => 'required'
            ]);

            $liaisonAgent = LiaisonAgent::where('phone_number', $request->phone_number)->firstOrFail();

            if ($liaisonAgent->generated_password == $request->password) {
                $result['success'] = true;

                $result['data'] = [
                    'id' => $liaisonAgent->id,
                    'token' => $liaisonAgent->token
                ];
            } else {
                $result['status'] = false;
                $result['message'] = "You could not be logged in because of an error";
                $statusCode = Response::HTTP_UNAUTHORIZED;
            }
        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        } catch (ModelNotFoundException $exception) {
            $result['status'] = false;
            $result['message'] = "Agent record not found";
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return response()->json($result, $statusCode);
    }

    public function list(Request $request) {
        $result = array();
        $statusCode = Response::HTTP_OK;

        try {
            $request->validate([
                'id' => 'required',
                'token' => 'required'
            ]);

            $liaisonAgent = LiaisonAgent::findOrFail($request->id);

            if ($liaisonAgent->token == $request->token) {
                $result['status'] = true;
                $result['data'] = LiaisonAgent::with(['child_agents', 'parent_agent'])->get();
            } else {
                $result['status'] = false;
                $result['message'] = "You are not authorized";
                $statusCode = Response::HTTP_UNAUTHORIZED;
            }
        } catch (ValidationException $exception) {
            $result['status'] = false;
            $result['message'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        } catch (ModelNotFoundException $exception) {
            $result['status'] = false;
            $result['message'] = "Agent record not found";
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return response()->json($result, $statusCode);
    }
}