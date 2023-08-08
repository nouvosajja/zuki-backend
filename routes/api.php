<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\plgnController;
use App\Http\Controllers\pktController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\priceController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\OrderController;
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



Route::group(['prefix' => 'price'], function () {
    Route::get('/all',[priceController::class ,'index']);
    Route::get('/filter',[priceController::class ,'filtered']);
    
});

Route::get('/paket',[pktController::class ,'index']);

Route::get('/user',[AuthenticationController::class ,'index'])->middleware('auth:sanctum');
Route::post('/user/update',[AuthenticationController::class ,'show'])->middleware('auth:sanctum');

Route::post('/login',[AuthenticationController::class, 'login']);
Route::post('/login',[AuthenticationController::class, 'login']);
Route::post('/register',[AuthenticationController::class, 'register']);
Route::post('/transaksi', 'TransaksiController@createOrder');


// push notif
Route::post('/save-token', [NotifController::class, 'saveToken'])->middleware('auth:sanctum');
Route::post('/payment/{id}', [OrderController::class, 'createOrder'])->middleware('auth:sanctum');
Route::post('/update/{id}', [OrderController::class, 'update'])->middleware('auth:sanctum');
