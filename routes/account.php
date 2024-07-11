<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;

// Authenticated stuff (should not be turned off with normal maintenance mode only full lock down)
Route::group(['middleware' => 'auth'], function () {

    Route::get('/dash/', fn() => redirect()->route('dashboard.main') );
    Route::get('/dashboard/', fn() => redirect()->route('dashboard.main') );

    // Add a prefix
    Route::group(['prefix' => vlx_get_account_url()], function() {

        // Dashboard
        Route::group(['namespace' => 'auth_navbar'],function() {
            Route::view('/', 'pages.account.dashboard')->name('dashboard.main');
        });

        // Logout
        // Post only for safety
        //Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Check if user is admin
        Route::middleware(['auth-admin'])->group(function () {

            // Users
            Route::view('/users', 'pages.account.user')->name('dashboard.user');

            // Users form endpoints
            Route::get( '/users/update/{user}', [UserController::class, 'edit']     )->name('dashboard.user.edit');     //BE
            Route::post('/users/update/{user}', [UserController::class, 'update']   )->name('dashboard.user.update');   //FE

            Route::get( '/users/delete/{user}', [UserController::class, 'trash']    )->name('dashboard.user.trash');    //BE
            Route::post('/users/delete/{user}', [UserController::class, 'delete']   )->name('dashboard.user.delete');   //FE



            // Users
            Route::view('/contact', 'pages.account.contact')->name('dashboard.contact');

            // Users form endpoints
            Route::get( '/contact/view/{contact}',      [ContactController::class, 'view'])->name('contact.view');      //FE

            Route::post('/contact/delete/{contact}',    [ContactController::class, 'delete'])->name('contact.delete');  //BE
            Route::get( '/contact/delete/{contact}',    [ContactController::class, 'trash'])->name('contact.trash');    //FE

        });
    });
});
