<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetController;

// Authentication stuff (should not be turned off with normal maintenance mode)
Route::group(['middleware' => 'guest'], function () {

    Route::get('/forgot-password', [ResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [ResetController::class, 'requestPost'])->name('password.request.post');

    Route::get('/reset-password/{token}', [ResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [ResetController::class, 'resetPost'])->name('password.reset.post');

    // Setup redirects to login and register
    Route::get('/register', fn() => redirect()->route('register') );
    Route::get('/login', fn() => redirect()->route('login') );

    // Add a prefix
    Route::group(['prefix' => vlxGetAuthUrl()], function() {

        // Register
        Route::get('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

        // Login (show first in guest navbar)
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

    });
});
