<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AuthToken extends Model
{
    
    protected $table = 'auth_tokens';


    protected $fillable = ['customer_id', 'token', 'expires_at'];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'dni');
    }


    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }

    // Generar un nuevo token para un usuario
    public static function generateToken($customer)
    {

        $randomNumber = rand(200, 500);
        $rawToken = $customer->email . now() . $randomNumber;
        $token = sha1($rawToken);


        $expiresAt = Carbon::now()->addHour();


        return self::create([
            'customer_id' => $customer->dni,
            'token' => $token,
            'expires_at' => $expiresAt
        ]);
    }


    public static function validateToken($token)
    {

        $authToken = self::where('token', $token)->first();


        if (!$authToken || $authToken->isExpired()) {
            return false;
        }

        return $authToken->customer; // Retorna el customer asociado si el token es válido
    }
}
