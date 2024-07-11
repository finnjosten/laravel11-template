<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\Item;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Maintenance mode

if(env('SETTING_MAINTENANCE')) {
    Route::view('/', 'pages.maintenance')->name('maintenance');
}

// Normal mode

Route::view('/', 'pages.home')->name('home');

// Pages for on the navbar
Route::group(['namespace' => 'navbar'],function() {
    Route::view('/about', 'pages.about-us')->name('about-us');

    Route::view('/contact', 'pages.contact')->name('contact');
});
Route::post('/contact', [ContactController::class, 'add'])->name('contact.add');




include __DIR__.'/auth.php';
include __DIR__.'/account.php';
include __DIR__.'/api.php';
