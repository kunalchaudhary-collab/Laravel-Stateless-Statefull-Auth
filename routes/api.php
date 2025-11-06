<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// state less authentication by api
// signup user api
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

// login user api
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});