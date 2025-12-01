<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get  ('contacts/index',          [ContactController::class, 'index']     )->name('contacts.index');
    Route::get  ('contacts/show/{id}',      [ContactController::class, 'show']      )->name('contacts.show');
    Route::post ('contacts/store',          [ContactController::class, 'store']     )->name('contacts.store');
    Route::post ('contacts/update/{id}',    [ContactController::class, 'update']    )->name('contacts.update');
    Route::post ('contacts/destroy/{id}',   [ContactController::class, 'destroy']   )->name('contacts.destroy');
});
