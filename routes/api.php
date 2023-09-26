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
use App\Http\Controllers\InboxController;
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

//User account
Route::get('/user/{id}',[AuthenticationController::class ,'index'])->middleware('auth:sanctum');
Route::get('/get-all',[AuthenticationController::class ,'getAllUsers']);
Route::post('/login',[AuthenticationController::class, 'login']);
Route::post('/register',[AuthenticationController::class, 'register']);
Route::post('/update/{id}', [AuthenticationController::class, 'show'])->middleware('auth:sanctum');

//Notification
Route::get('/inbox-view',[InboxController::class ,'inboxView'])->middleware('auth:sanctum');
Route::post('/notif-pesenan-selesai/{id}', [OrderController::class, 'notifPesananSelesai'])->middleware('auth:sanctum');
Route::post('/save-token', [NotifController::class, 'saveToken'])->middleware('auth:sanctum');

//Transaction
Route::get('/paket',[pktController::class ,'index']);
Route::get('/price',[priceController::class ,'index']);
Route::post('/order', [OrderController::class, 'createOrder'])->middleware('auth:sanctum');
Route::post('/input-berat/{id}', [OrderController::class, 'inputBerat'])->middleware('auth:sanctum');
Route::post('/confirm-order/{id}', [OrderController::class, 'confirmOrder'])->middleware('auth:sanctum');
Route::post('/finish-order/{id}', [OrderController::class, 'setOrderSelesai'])->middleware('auth:sanctum');
Route::get('/get-order/{id}', [OrderController::class, 'listOrder'])->middleware('auth:sanctum');
Route::get('/get-order-user', [OrderController::class, 'listOrderByUser'])->middleware('auth:sanctum');
Route::get('/menunggu-dikonfirmasi/{id}', [OrderController::class, 'listOrderMenungguDikonfirmasi'])->middleware('auth:sanctum');
Route::get('/list-order-selesai/{id}', [OrderController::class, 'listOrderSelesai'])->middleware('auth:sanctum');
Route::get('/filter', [OrderController::class, 'filtered']);
Route::post('/midtrans-callback', [OrderController::class, 'midtransCallback']);