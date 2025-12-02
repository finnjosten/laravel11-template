<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('get-cookie/{cookie_name}',          [ApiController::class, "getCookie"])->name('api.get-cookie');
Route::get('set-cookie/{cookie_name}/{data}',   [ApiController::class, "setCookie"])->name('api.set-cookie');
