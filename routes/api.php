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
Route::get('/price',[priceController::class ,'index']);

Route::get('/user',[AuthenticationController::class ,'index'])->middleware('auth:sanctum');
Route::post('/user/update',[AuthenticationController::class ,'show'])->middleware('auth:sanctum');

Route::post('/login',[AuthenticationController::class, 'login']);
Route::post('/login',[AuthenticationController::class, 'login']);
Route::post('/register',[AuthenticationController::class, 'register']);
Route::post('/transaksi', 'TransaksiController@createOrder');

Route::get('/filter', [OrderController::class, 'filtered']);
Route::post('/input-berat/{id}', [OrderController::class, 'inputBerat'])->middleware('auth:sanctum');
Route::post('/save-token', [NotifController::class, 'saveToken'])->middleware('auth:sanctum');
Route::post('/order', [OrderController::class, 'createOrder'])->middleware('auth:sanctum');
Route::post('/update/{id}', [OrderController::class, 'update'])->middleware('auth:sanctum');
Route::post('/notif-pesenan-selesai/{id}', [OrderController::class, 'notifPesananSelesai'])->middleware('auth:sanctum');
Route::get('/get-order/{id}', [OrderController::class, 'listOrder'])->middleware('auth:sanctum');
Route::post('/confirm-order/{id}', [OrderController::class, 'confirmOrder'])->middleware('auth:sanctum');
Route::put('/finish-order/{id}', [OrderController::class, 'finishOrder'])->middleware('auth:sanctum');
Route::get('/get-order-user/{id}', [OrderController::class, 'listOrderByUser'])->middleware('auth:sanctum');
Route::get('/list-order-selesai/{id}', [OrderController::class, 'listOrderSelesai'])->middleware('auth:sanctum');
Route::post('/midtrans-callback', [OrderController::class, 'midtransCallback']);
// Route::post('/payment/{id}', [OrderController::class, 'payment'])->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/update/{id}', [AuthenticationController::class, 'update'])->middleware('auth:sanctum');
    Route::get('/user', [AuthenticationController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/user/{id}', [AuthenticationController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/save-token', [NotifController::class, 'saveToken'])->middleware('auth:sanctum');
    Route::post('/send-notif', [NotifController::class, 'sendNotif'])->middleware('auth:sanctum');
    Route::get('/get-order', [OrderController::class, 'listOrder'])->middleware('auth:sanctum');
    Route::get('/get-order/{id}', [OrderController::class, 'showOrder'])->middleware('auth:sanctum');
    Route::post('/confirm-order/{id}', [OrderController::class, 'confirmOrder'])->middleware('auth:sanctum');
    Route::put('/finish-order', [OrderController::class, 'finishOrder'])->middleware('auth:sanctum');
    Route::get('/get-order-user', [OrderController::class, 'listOrderByUser'])->middleware('auth:sanctum');
    
});
Route::post('/midtrans-callback', [OrderController::class, 'midtransCallback']);