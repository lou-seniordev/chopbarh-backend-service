<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CheckHashMac
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
        $params = $request->all();
        array_walk_recursive($params, function (&$item, $key) {
            $item = null === $item ? '' : $item;
        });

        $query = json_encode($params);
        $signature = hash_hmac('sha256', $query, env('HASH_SECRET_KEY'));
        if ($request->header('verification-hash') == $signature) return $next($request);
        else return response()->json([
            'status' => false,
            'message' => $signature,
            'query' => $query
        ], Response::HTTP_UNAUTHORIZED);
    }
}
