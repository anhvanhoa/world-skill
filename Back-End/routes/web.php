<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReportsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     // return view('welcome');
//     echo Hash::make('123456');
// });


Route::get('/', [LoginController::class, 'index']);
Route::post('/', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/event', [EventController::class, 'index'])
    ->middleware('checkLogin')
    ->name('event');
Route::get('/event/create', [EventController::class, 'formCreate'])
    ->middleware('checkLogin')
    ->name('create-event');
Route::post('/event/create', [EventController::class, 'create'])
    ->middleware('checkLogin')
    ->name('create-event');
Route::get('/event/{slug}', [EventController::class, 'detailEvent'])
    ->middleware('checkLogin')
    ->name('detail-event');
Route::get('/event/{slug}/edit', [EventController::class, 'editEvent'])
    ->middleware('checkLogin')
    ->name('edit-event');
Route::put('/event/{id}/update', [EventController::class, 'updateEvent'])
    ->middleware('checkLogin')
    ->name('update-event');


Route::get('/ticket/{slug}/create', [TicketController::class, 'formCreate'])
    ->middleware('checkLogin')
    ->name('create-ticket');
Route::post('/ticket/{id}/create', [TicketController::class, 'create'])
    ->middleware('checkLogin')
    ->name('create-ticket');


Route::get('/session/{slug}/create', [SessionController::class, 'formCreate'])
    ->middleware('checkLogin')
    ->name('session');
Route::post('/session/create', [SessionController::class, 'create'])
    ->middleware('checkLogin')
    ->name('create-session');
Route::get('/session/{slug}-{id}/edit', [SessionController::class, 'updateForm'])
    ->middleware('checkLogin')
    ->name('edit-session');
Route::put('/session/{id}/update', [SessionController::class, 'update'])
    ->middleware('checkLogin')
    ->name('update-session');


Route::get('/channel/{slug}/create', [ChannelController::class, 'index'])
    ->middleware('checkLogin')
    ->name('channel');
Route::post('/channel/{id}/create', [ChannelController::class, 'create'])
    ->middleware('checkLogin')
    ->name('create-channel');

Route::get('/room/{slug}/create', [RoomController::class, 'index'])
    ->middleware('checkLogin')
    ->name('room');
Route::post('/room/create', [RoomController::class, 'create'])
    ->middleware('checkLogin')
    ->name('create-room');

Route::get('/reports/{slug}', [ReportsController::class, 'index'])
    ->middleware('checkLogin')
    ->name('reports');
