<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/api/get-cookie/{cookie_name}', [ApiController::class, "getCookie"]);
Route::get('/api/set-cookie/{cookie_name}/{data}', [ApiController::class, "setCookie"]);
