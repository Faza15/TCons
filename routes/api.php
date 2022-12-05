<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\UserCheck;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {

    Route::middleware([AdminCheck::class])->group(function () {
        Route::resource('tickets', TicketController::class, ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::resource('transactions', TransactionController::class, ['only' => ['index', 'update', 'destroy']]);
    });

    Route::middleware([UserCheck::class])->group(function () {
        Route::resource('transactions', TransactionController::class, ['only' => ['show', 'store']]);
    });
    
    //public
    Route::resource('tickets', TicketController::class, ['only' => ['index']]);
    Route::post('logout', [AuthController::class, 'logout']);
});
