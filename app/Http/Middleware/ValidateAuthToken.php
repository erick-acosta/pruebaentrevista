<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AuthToken;

class ValidateAuthToken
{
    public function handle($request, Closure $next)
    {

        $token = $request->header('Authorization');

       
        if (!AuthToken::validateToken($token)) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired token'], 401);
        }

        return $next($request);
    }
}
