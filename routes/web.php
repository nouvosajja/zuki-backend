<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\dashboardPaketController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\dashboardPelangganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LoginController;
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
Route::get('/home', function () {
    return view('home');
});

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->middleware('auth','isAdmin')->group(function ()  {
    // Route::get('/home', function () {
    //     return view('home');
    // })->middleware('auth');
    // Route::get('/index', [dashboardController::class, 'index']);
    
    Route::group(['prefix' => 'paket'], function () {
        Route::get('/all', [dashboardPaketController::class, 'index'])->middleware('auth');
        Route::get('/detail/{s}', [dashboardPaketController::class, 'show'])->middleware('auth');
        Route::get('/create', [PaketController::class, 'create'])->middleware('auth');
        Route::post('/add', [PaketController::class, 'store'])->middleware('auth');
        Route::delete('/delete/{paket}', [PaketController::class, 'destroy'])->middleware('auth');
        Route::get('/edit/{paket}', [PaketController::class, 'edit'])->middleware('auth');
        Route::post('/update/{paket}', [PaketController::class, 'update'])->middleware('auth');
        Route::get('/search', [dashboardPaketController::class, 'search']);
    });
    
    
    Route::group(['prefix' => 'pelanggan'], function () {
        Route::get('/all', [dashboardPelangganController::class, 'index'])->middleware('auth');
        Route::get('/detail/{kelas}', [dashboardkelasController::class, 'show'])->middleware('auth');
        Route::get('/create', [PelangganController::class, 'create'])->middleware('auth');
        Route::post('/add', [PelangganController::class, 'store'])->middleware('auth');
        Route::delete('/delete/{paket}', [PelangganController::class, 'destroy'])->middleware('auth');
        Route::get('/edit/{paket}', [PelangganController::class, 'edit'])->middleware('auth');
        Route::post('/update/{paket}', [PelangganController::class, 'update'])->middleware('auth');
        Route::get('/search', [dashboardPelangganController::class, 'search']);
    });
});

Route::group(['prefix' => 'session'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/logins', [LoginController::class, 'auth']);
    Route::post('/logout', [LoginController::class, 'logout']);
    
    
});

