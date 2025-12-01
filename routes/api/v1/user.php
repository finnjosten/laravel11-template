<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get( 'profile/show',         [ProfileController::class, 'show']      )->name('profile.show');
    Route::post('profile/update',       [ProfileController::class, 'update']    )->name('profile.update');
    Route::post('profile/destroy',      [ProfileController::class, 'destroy']   )->name('profile.destroy');

    Route::get  ('users/index',         [UserController::class, 'index']    )->name('users.index');
    Route::get  ('users/show/{id}',     [UserController::class, 'show']     )->name('users.show');
    Route::post ('users/store',         [UserController::class, 'store']    )->name('users.store');
    Route::post ('users/update/{id}',   [UserController::class, 'update']   )->name('users.update');
    Route::post ('users/destroy/{id}',  [UserController::class, 'destroy']  )->name('users.destroy');
});
