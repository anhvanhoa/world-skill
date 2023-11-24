<?php

use App\Http\Controllers\EventApiController;
use App\Http\Controllers\AccountApiController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('v1/events', [EventApiController::class, 'index']);
Route::get('v1/organizers/{organizerSlug}/events/{eventSlug}', [EventApiController::class, 'detailEvent']);
Route::post('v1/organizers/{organizerSlug}/events/{eventSlug}/registration', [EventApiController::class, 'registration']);
Route::get('v1/registration', [EventApiController::class, 'getRegistration']);

Route::post('v1/login', [AccountApiController::class, 'login']);
Route::post('v1/logout', [AccountApiController::class, 'logout']);
