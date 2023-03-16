<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// login and register 
Route::post('/create', [AuthController::class,'UserAuth']);
Route::post('/login', [AuthController::class,'loginUser']);


/// proteceted routes
Route::group(['middleware' => ['auth:sanctum']],  function () {
    Route::post('/suspect', [FormController::class,'suspect']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
