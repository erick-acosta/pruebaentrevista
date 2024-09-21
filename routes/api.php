<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::middleware('auth:api')->group(function () {
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('/customers', [CustomerController::class, 'show']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
});
