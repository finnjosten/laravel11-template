<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get  ('roles/index',         [RoleController::class, 'index']    )->name('roles.index');
    Route::get  ('roles/show/{id}',     [RoleController::class, 'show']     )->name('roles.show');
    Route::post ('roles/store',         [RoleController::class, 'store']    )->name('roles.store');
    Route::post ('roles/update/{id}',   [RoleController::class, 'update']   )->name('roles.update');
    Route::post ('roles/destroy/{id}',  [RoleController::class, 'destroy']  )->name('roles.destroy');
});
