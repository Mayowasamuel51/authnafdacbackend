<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\UNIT\UnitOneOsunController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Controllers\API\UNIT\UnitOneOsun;



Route::get('/check', [FormController::class, 'check']);

// login and register 
Route::post('/create', [AuthController::class, 'UserAuth']);
Route::post('/login', [AuthController::class, 'loginUser']);


/// proteceted routes
Route::group(['middleware' => ['auth:sanctum']],  function () {
    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message' => 'Your are in ', 'status' => 200], 200);
    });
    // more info.................
    Route::get('/moreinfo/{martic_number}', [FormController::class, 'more_info']);

    Route::post('/surety/{id}', [FormController::class, 'surety']);
    // create a new suspect 
    Route::post('/suspect', [FormController::class, 'suspect']);

   
    Route::get('/suspectinfo', [FormController::class, 'getYear']);
    Route::get('/suspectfullyear', [FormController::class, 'getFullYear']);
    
    Route::get('/suspect/{unitId}', [FormController::class, 'getAllSuspect']);

     //logout for the system
     Route::post('/logout', [AuthController::class, 'logout']);
    
});




// Route::group(['middleware' => ['unitOneOsun']],  function () {
//     Route::post('/login/un', [UnitOneOsunController::class, 'login']);    
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// {
//     "unitId":"LagosID121113",
//    "tokenpass":"rfid",
//     "password":"1234567"
// }