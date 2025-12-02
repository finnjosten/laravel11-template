<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get( 'profile/show',         [ProfileController::class, 'show']      )->name('api.profile.show');
    Route::post('profile/update',       [ProfileController::class, 'update']    )->name('api.profile.update');
    Route::post('profile/destroy',      [ProfileController::class, 'destroy']   )->name('api.profile.destroy');

    Route::get  ('users/index',         [UserController::class, 'index']    )->name('api.users.index');
    Route::get  ('users/show/{id}',     [UserController::class, 'show']     )->name('api.users.show');
    Route::post ('users/store',         [UserController::class, 'store']    )->name('api.users.store');
    Route::post ('users/update/{id}',   [UserController::class, 'update']   )->name('api.users.update');
    Route::post ('users/destroy/{id}',  [UserController::class, 'destroy']  )->name('api.users.destroy');
});
