<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;

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
        Route::view('/', 'pages.account.dashboard')->name('dashboard.main');

        // Profile
        Route::get( '/profile',         [ProfileController::class, 'show']      )->name('profile');

        // Users form endpoints
        Route::get( '/profile/edit',    [ProfileController::class, 'edit']      )->name('profile.edit');    //FE
        Route::post('/profile/edit',    [ProfileController::class, 'update']    )->name('profile.update');  //BE

        Route::get( '/profile/delete',  [ProfileController::class, 'trash']     )->name('profile.trash');   //FE
        Route::post('/profile/delete',  [ProfileController::class, 'destroy']   )->name('profile.destroy'); //BE

        // Check if user is admin
        Route::middleware(['auth-admin'])->group(function () {

            // Users
            Route::view('/users', 'pages.account.users.index')->name('dashboard.user');

            // Users form endpoints
            Route::get( '/users/create',        [UserController::class, 'create']   )->name('dashboard.user.create');  //FE
            Route::post('/users/create',        [UserController::class, 'store']    )->name('dashboard.user.store');   //BE

            Route::get( '/users/update/{user}', [UserController::class, 'edit']     )->name('dashboard.user.edit');     //FE
            Route::post('/users/update/{user}', [UserController::class, 'update']   )->name('dashboard.user.update');   //BE

            Route::get( '/users/delete/{user}', [UserController::class, 'trash']    )->name('dashboard.user.trash');    //FE
            Route::post('/users/delete/{user}', [UserController::class, 'destroy']  )->name('dashboard.user.delete');   //BE



            // Contact
            Route::view('/contact', 'pages.account.contact.index')->name('dashboard.contact');

            // Contact form endpoints
            Route::get( '/contact/view/{contact}',      [ContactController::class, 'view'])->name('dashboard.contact.view');      //FE

            Route::get( '/contact/delete/{contact}',    [ContactController::class, 'trash'])->name('dashboard.contact.trash');    //FE
            Route::post('/contact/delete/{contact}',    [ContactController::class, 'delete'])->name('dashboard.contact.delete');  //BE



            // Pages
            Route::get( '/pages',               [PageController::class, 'index'])->name('dashboard.pages');

            // Pages form endpoints
            Route::get( '/pages/create',        [PageController::class, 'create']   )->name('dashboard.pages.create');  //FE
            Route::post('/pages/create',        [PageController::class, 'store']    )->name('dashboard.pages.store');   //BE

            Route::get( '/pages/update/{id}',   [PageController::class, 'edit']     )->name('dashboard.pages.edit');    //FE
            Route::post('/pages/update/{id}',   [PageController::class, 'update']   )->name('dashboard.pages.update');  //BE

            Route::get( '/pages/delete/{id}',   [PageController::class, 'trash']    )->name('dashboard.pages.trash');   //FE
            Route::post('/pages/delete/{id}',   [PageController::class, 'destroy']  )->name('dashboard.pages.delete');  //BE



            // Menus
            Route::get( '/menus',               [MenuController::class, 'index']    )->name('dashboard.menus');

            // Menus form endpoints
            Route::get( '/menus/create',        [MenuController::class, 'create']   )->name('dashboard.menus.create');  //FE
            Route::post('/menus/create',        [MenuController::class, 'store']    )->name('dashboard.menus.store');   //BE

            Route::get( '/menus/update/{id}',   [MenuController::class, 'edit']     )->name('dashboard.menus.edit');    //FE
            Route::post('/menus/update/{id}',   [MenuController::class, 'update']   )->name('dashboard.menus.update');  //BE

            Route::get( '/menus/delete/{id}',   [MenuController::class, 'trash']    )->name('dashboard.menus.trash');   //FE
            Route::post('/menus/delete/{id}',   [MenuController::class, 'destroy']  )->name('dashboard.menus.delete');  //BE

        });
    });
});
