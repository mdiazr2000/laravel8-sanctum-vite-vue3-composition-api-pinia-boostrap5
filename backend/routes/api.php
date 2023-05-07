<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/client', [ClientController::class, 'store'])->name('store');
Route::get('/client/{id}', [ClientController::class, 'show'])->name('show');

Route::get('/user', [UserController::class, 'user'])->name('user')
    ->middleware(['auth:sanctum', 'ability:see_user']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout')
    ->middleware(['auth:sanctum', 'ability:see_user']);

Route::get('/client', [ClientController::class, 'show'])->name('show')
    ->middleware(['auth:sanctum', 'ability:see_client']);
Route::get('/client/reservations/{clientId}', [ClientController::class, 'reservations'])->name('reservations')
    ->middleware(['auth:sanctum', 'ability:see_reservation']);
Route::get('/clients', [ClientController::class, 'index'])->name('index')
    ->middleware(['auth:sanctum', 'ability:list_client']);

Route::get('/books', [\App\Http\Controllers\BookController::class, 'index'])->name('index')
    ->middleware(['auth:sanctum', 'ability:list_book']);

Route::get('/books/available', [\App\Http\Controllers\BookController::class, 'availableToReserve'])
    ->name('availableToReserve')
    ->middleware(['auth:sanctum', 'ability:see_book']);

Route::post('/book', [\App\Http\Controllers\BookController::class, 'store'])->name('store')
    ->middleware(['auth:sanctum', 'ability:add_book']);

Route::get('/book/{id}', [\App\Http\Controllers\BookController::class, 'show'])->name('show')
    ->middleware(['auth:sanctum', 'ability:see_book']);

Route::put('/book', [\App\Http\Controllers\BookController::class, 'update'])->name('update')
    ->middleware(['auth:sanctum', 'ability:edit_book']);

Route::delete('/book/{id}', [\App\Http\Controllers\BookController::class, 'destroy'])->name('destroy')
    ->middleware(['auth:sanctum']);

Route::post('/book/reserve', [\App\Http\Controllers\BookController::class, 'reserve'])->name('reserve')
    ->middleware(['auth:sanctum', 'ability:add_reservation']);

Route::get('/book/unreserve/{id}', [\App\Http\Controllers\BookController::class, 'unreserve'])->name('unreserve')
    ->middleware(['auth:sanctum', 'ability:delete_reservation']);

Route::get('/reservations', [\App\Http\Controllers\ReservationController::class, 'index'])->name('index')
    ->middleware(['auth:sanctum', 'ability:list_reservation']);
