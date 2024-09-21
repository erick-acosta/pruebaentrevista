<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AuthToken;

class AuthTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Token no proporcionado'], 401);
        }

        $customer = AuthToken::validateToken($token);

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Token inválido o expirado'], 401);
        }


        $request->customer = $customer;


        return $next($request);
    }
}
