<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('api-key');

        if ($apiKey == "200aeco-190aefd30-aecobdq") return $next($request);
        else return response()->json([
            'status' => false,
            'message' => 'Unauthorized'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
