<?php

use App\Http\Controllers\OtpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/registerUser', [\App\Http\Controllers\UserController::class, 'registerUser']);

Route::middleware('auth:api')->group(function () {
    Route::get('/otp/generate', [OtpController::class, 'generateOtp']);
    Route::get('/otp/verify/{otp}', [OtpController::class, 'verifyOtp']);
});
