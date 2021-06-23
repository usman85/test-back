<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// list of all doctors
Route::get('/doctors', [DoctorController::class, 'index']);
// list availabilities of doctor
Route::get('/doctors/{doctorId}/availabilities', [DoctorController::class, 'availabilities']);

/**
 * Route is for authenticating  user for Api
 */
Route::post('login', [UserController::class, 'index']);

/**
 * Using middleware to bookings 

 */
Route::middleware('auth:sanctum')->group( function () {
    // List alll bookings
    Route::get('bookings', [BookingController::class, 'index']);
    
    // create new booking
    Route::post('bookings', [BookingController::class, 'create']);
    
    // cancel booking by given Id
    Route::get('/bookings/{bookingId}/cancel', [BookingController::class, 'updateStatus']);
});
