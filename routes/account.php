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
    Route::group(['prefix' => vlx_get_auth_url()], function() {
        // Logout
        // Post only for safety
        Route::get( '/logout', [AuthController::class, 'logout'])->name('logout.get');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    // Add a prefix
    Route::group(['prefix' => vlx_get_account_url()], function() {

        // Dashboard
        Route::group(['namespace' => 'auth_navbar'],function() {
            Route::view('/', 'pages.account.dashboard')->name('dashboard.main');
        });

        // Profile
        Route::get( '/profile',         [UserController::class, 'profile']    )->name('profile');

        // Users form endpoints
        Route::get( '/profile/edit',    [UserController::class, 'editProfile']  )->name('profile.edit');    //FE
        Route::post('/profile/edit',    [UserController::class, 'update']       )->name('profile.update');  //BE

        Route::get( '/profile/delete',  [UserController::class, 'trashProfile']     )->name('profile.trash');   //FE
        Route::post('/profile/delete',  [UserController::class, 'destroyProfile']   )->name('profile.destroy'); //BE

        // Check if user is admin
        Route::middleware(['auth-admin'])->group(function () {

            // Users
            Route::view('/users', 'pages.account.users.index')->name('dashboard.user');

            // Users form endpoints
            Route::get( '/users/update/{user}', [UserController::class, 'edit']     )->name('dashboard.user.edit');     //FE
            Route::post('/users/update/{user}', [UserController::class, 'update']   )->name('dashboard.user.update');   //BE

            Route::get( '/users/delete/{user}', [UserController::class, 'trash']    )->name('dashboard.user.trash');    //FE
            Route::post('/users/delete/{user}', [UserController::class, 'destroy']   )->name('dashboard.user.delete');   //BE



            // Users
            Route::view('/contact', 'pages.account.contact.index')->name('dashboard.contact');

            // Users form endpoints
            Route::get( '/contact/view/{contact}',      [ContactController::class, 'view'])->name('dashboard.contact.view');      //FE

            Route::get( '/contact/delete/{contact}',    [ContactController::class, 'trash'])->name('dashboard.contact.trash');    //FE
            Route::post('/contact/delete/{contact}',    [ContactController::class, 'delete'])->name('dashboard.contact.delete');  //BE

        });
    });
});
