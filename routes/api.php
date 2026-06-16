<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DaftarBelanjaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderanController;
use App\Http\Controllers\RestoranController;
use App\Http\Controllers\SayurController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);
    Route::get('/users', [UserController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/laporan', [LaporanController::class, 'index']);

    Route::apiResource('restoran', RestoranController::class);
    Route::apiResource('sayur', SayurController::class);

    Route::get('/orderan', [OrderanController::class, 'index']);
    Route::post('/orderan', [OrderanController::class, 'store']);
    Route::get('/orderan/{orderan}', [OrderanController::class, 'show']);
    Route::patch('/orderan/{orderan}/proses', [OrderanController::class, 'proses']);
    Route::patch('/orderan/{orderan}/selesai', [OrderanController::class, 'selesai']);

    Route::get('/daftar-belanja', [DaftarBelanjaController::class, 'index']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
});
