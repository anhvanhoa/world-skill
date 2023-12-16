<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\TicketEventController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ChannelsController;
use App\Http\Controllers\RoomsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'loginShow'])->name('login');
Route::post('/login', [AuthController::class, 'loginHandle'])->name('loginHandle');
Route::get('/logout', [AuthController::class, 'logoutHandle'])->name('logout');

Route::get('/events', [EventsController::class, 'eventsShow'])->middleware('check-login')->name('events');
Route::get('/event/{slug}', [EventsController::class, 'eventDetailShow'])->middleware('check-login')->name('event');
Route::get('/event-add', [EventsController::class, 'eventAdd'])->middleware('check-login')->name('eventAdd');
Route::post('/event-add', [EventsController::class, 'eventHandle'])->middleware('check-login')->name('eventHandle');
Route::get('/event-edit/{id}', [EventsController::class, 'eventEdit'])->middleware('check-login')->name('eventEdit');
Route::post('/event-edit/{id}', [EventsController::class, 'eventEditHandle'])->middleware('check-login')->name('eventEditHandle');

Route::get('/event/ticket/{id}', [TicketEventController::class, 'ticketShow'])->middleware('check-login')->name('ticket');
Route::post('/event/ticket/{id}', [TicketEventController::class, 'ticketHandle'])->middleware('check-login')->name('ticketHandle');

Route::get('/event/session/{id}', [SessionsController::class, 'sessionShowAdd'])->middleware('check-login')->name('sessionShowAdd');
Route::post('/event/session/{id}', [SessionsController::class, 'sessionHandleAll'])->middleware('check-login')->name('sessionHandleAll');
Route::get('/event/session-edit/{id}', [SessionsController::class, 'sessionShowEdit'])->middleware('check-login')->name('sessionShowEdit');
Route::post('/event/session-edit/{id}', [SessionsController::class, 'sessionHandleEdit'])->middleware('check-login')->name('sessionHandleEdit');

Route::get('/event/channel/{id}', [ChannelsController::class, 'channelShow'])->middleware('check-login')->name('channelShow');
Route::post('/event/channel/{id}', [ChannelsController::class, 'channelHandle'])->middleware('check-login')->name('channelHandle');

Route::get('/event/room/{id}', [RoomsController::class, 'roomShow'])->middleware('check-login')->name('roomShow');
Route::post('/event/room/{id}', [RoomsController::class, 'roomHandle'])->middleware('check-login')->name('roomHandle');