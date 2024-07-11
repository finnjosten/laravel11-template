<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Authentication stuff (should not be turned off with normal maintenance mode)
Route::group(['middleware' => 'guest', 'prefix'], function () {

    // Setup redirects to login and register
    Route::get('/register', fn() => redirect()->route('register') );
    Route::get('/login', fn() => redirect()->route('login') );

    // Add a prefix
    Route::group(['prefix' => vlx_get_auth_url()], function() {

        // Register
        Route::get('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

        // Login (show first in guest navbar)
        Route::group(['namespace' => 'guest_navbar'],function() {
            Route::get('/login', [AuthController::class, 'login'])->name('login');
        });
        Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

    });
});
