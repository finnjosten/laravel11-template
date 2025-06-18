<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/api/get-cookie/{cookie_name}', [ApiController::class, "getCookie"]);
Route::get('/api/set-cookie/{cookie_name}/{data}', [ApiController::class, "setCookie"]);


// Add a prefix
Route::group(['prefix' => "api/v1"], function() {

    //Route::any('/{any?}', function () { return response()->json([ 'status' => 'fatal', 'message' => 'API not found' ], 404); })->fallback() ->where('any', '.*');

    // Authentication
    Route::post('auth/register', [AuthController::class, 'registerPost'])->name('register.api');
    Route::post('auth/login', [AuthController::class, 'loginPost'])->name('login.api');


    // Menus (only public INDEX and SHOW)
    Route::get( '/menus/index',             [MenuController::class, 'index']    );
    Route::get( '/menus/show/{id}',         [MenuController::class, 'show']     );

    // Pages (only public SHOW)
    Route::get( '/pages/show/{identifier}', [PageController::class, 'show']     );


    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Logout (Public to authenticated users)
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout.api');

        // Profile (Public to authenticated users)
        Route::get( '/profile',                 [ProfileController::class, 'show']      );
        Route::post('/profile/update',          [ProfileController::class, 'update']    );
        Route::post('/profile/destroy',         [ProfileController::class, 'destroy']   );

        // Check if user is admin
        Route::middleware(['auth-admin'])->group(function () {

            // Users
            Route::get( '/users/index',             [UserController::class, 'index']    );
            Route::get( '/users/show/{id}',         [UserController::class, 'show']     );
            Route::post('/users/store',             [UserController::class, 'store']    );
            Route::post('/users/update/{id}',       [UserController::class, 'update']   );
            Route::post('/users/destroy/{id}',      [UserController::class, 'destroy']  );

            // Contact
            Route::get( '/contacts/index',          [ContactController::class, 'index']     );
            Route::get( '/contacts/show/{id}',      [ContactController::class, 'show']      );
            Route::post('/contacts/store',          [ContactController::class, 'store']     );
            Route::post('/contacts/destroy/{id}',   [ContactController::class, 'destroy']   );

            // Pages
            Route::get( '/pages/index',             [PageController::class, 'index']    );
            Route::post('/pages/store',             [PageController::class, 'store']    );
            Route::post('/pages/update/{id}',       [PageController::class, 'update']   );
            Route::post('/pages/destroy/{id}',      [PageController::class, 'destroy']  );

            // Menus
            Route::post('/menus/store',             [MenuController::class, 'store']    );
            Route::post('/menus/update/{id}',       [MenuController::class, 'update']   );
            Route::post('/menus/destroy/{id}',      [MenuController::class, 'destroy']  );

        });

    });
});
