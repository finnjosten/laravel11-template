<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Authentication stuff (should not be turned off with normal maintenance mode)
Route::group(['middleware' => 'guest'], function () {

    Route::get('/forgot-password', [AuthController::class, 'reset'])->name('reset');
    Route::post('/forgot-password', [AuthController::class, 'resetPost'])->name('reset.post');

    // Setup redirects to login and register
    Route::get('/register', fn() => redirect()->route('register') );
    Route::get('/login', fn() => redirect()->route('login') );

    // Add a prefix
    Route::group(['prefix' => vlx_get_auth_url()], function() {

        // Register
        Route::get('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

        // Login (show first in guest navbar)
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

    });
});
