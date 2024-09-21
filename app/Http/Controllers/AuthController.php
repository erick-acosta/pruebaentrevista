<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\AuthToken;
use Illuminate\Support\Facades\Hash;

use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $customer = Customer::where('email', $request->email)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            $authToken = AuthToken::generateToken($customer);

            return response()->json([
                'success' => true,
                'token' => $authToken->token,
                'expires_at' => $authToken->expires_at
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
    }
}
