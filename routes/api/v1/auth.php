<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register',    [AuthController::class, 'registerPost'] )->name('api.register');
    Route::post('/login',       [AuthController::class, 'loginPost']    )->name('api.login');
    Route::post('/logout',      [AuthController::class, 'logout']       )->name('api.logout')->middleware('auth:sanctum');
});
