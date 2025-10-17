<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PhoneAuthController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Mobil ilova uchun API
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Telefon orqali autentifikatsiya
Route::prefix('auth')->group(function () {
    Route::post('/send-code', [PhoneAuthController::class, 'sendCode']);
    Route::post('/verify-code', [PhoneAuthController::class, 'verifyCode']);
    Route::post('/complete-registration', [PhoneAuthController::class, 'completeRegistration']);
});
