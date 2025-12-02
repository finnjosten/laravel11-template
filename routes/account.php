<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VerifyController;
use App\Http\Controllers\ProfileController;

Route::get('/email/verify/{id}/{hash}', [VerifyController::class, 'verify'])->middleware('signed')->name('verification.verify');

// Authenticated stuff (should not be turned off with normal maintenance mode only full lock down)
Route::group(['middleware' => 'auth'], function () {

    Route::get('/dash/', fn() => redirect()->route('dashboard.main') );
    Route::get('/dashboard/', fn() => redirect()->route('dashboard.main') );

    Route::get('/email/verify', [VerifyController::class, 'notice'])->name('verification.notice');
    Route::post('/email/verification-notification', [VerifyController::class, 'send'])->name('verification.send');

    // Add a prefix
    Route::group(['prefix' => vlxGetAuthUrl()], function() {
        // Logout
        // Post only for safety
        Route::get( '/logout', [AuthController::class, 'logout'])->name('logout.get');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    // Add a prefix
    Route::group(['prefix' => vlxGetAccountUrl()], function() {

        // Dashboard
        //Route::view('/', 'pages.account.dashboard')->name('dashboard.main');
        Route::get('/', fn() => redirect()->route('profile') )->name('dashboard.main');

        // Profile
        Route::get( '/profile',             [ProfileController::class, 'show']      )->name('profile');

        // Users form endpoints
        Route::get( '/profile/edit',        [ProfileController::class, 'edit']      )->name('profile.edit');    //FE
        Route::post('/profile/edit',        [ProfileController::class, 'update']    )->name('profile.update');  //BE

        Route::get( '/profile/delete',      [ProfileController::class, 'trash']     )->name('profile.trash');   //FE
        Route::post('/profile/delete',      [ProfileController::class, 'destroy']   )->name('profile.destroy'); //BE



        // Users
        Route::get( '/users',               [UserController::class, 'index']    )->name('dashboard.user');

        // Users form endpoints
        Route::get( '/users/create',        [UserController::class, 'create']   )->name('dashboard.user.create');   //FE
        Route::post('/users/create',        [UserController::class, 'store']    )->name('dashboard.user.store');    //BE

        Route::get( '/users/update/{user}', [UserController::class, 'edit']     )->name('dashboard.user.edit');     //FE
        Route::post('/users/update/{user}', [UserController::class, 'update']   )->name('dashboard.user.update');   //BE

        Route::get( '/users/delete/{user}', [UserController::class, 'trash']    )->name('dashboard.user.trash');    //FE
        Route::post('/users/delete/{user}', [UserController::class, 'destroy']  )->name('dashboard.user.delete');   //BE



        // Roles
        Route::get( '/roles',               [RoleController::class, 'index']    )->name('dashboard.role');

        // Roles form endpoints
        Route::get( '/roles/create',        [RoleController::class, 'create']   )->name('dashboard.role.create');   //FE
        Route::post('/roles/create',        [RoleController::class, 'store']    )->name('dashboard.role.store');    //BE

        Route::get( '/roles/update/{role}', [RoleController::class, 'edit']     )->name('dashboard.role.edit');     //FE
        Route::post('/roles/update/{role}', [RoleController::class, 'update']   )->name('dashboard.role.update');   //BE

        Route::get( '/roles/delete/{role}', [RoleController::class, 'trash']    )->name('dashboard.role.trash');    //FE
        Route::post('/roles/delete/{role}', [RoleController::class, 'destroy']  )->name('dashboard.role.delete');   //BE



        // Contact
        Route::view('/contact', 'pages.account.contact.index')->name('dashboard.contact');

        // Contact form endpoints
        Route::get( '/contact/view/{contact}',      [ContactController::class, 'view']      )->name('dashboard.contact.view');      //FE

        Route::get( '/contact/delete/{contact}',    [ContactController::class, 'trash']     )->name('dashboard.contact.trash');     //FE
        Route::post('/contact/delete/{contact}',    [ContactController::class, 'destroy']   )->name('dashboard.contact.delete');    //BE
    });
});
