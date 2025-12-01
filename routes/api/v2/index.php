<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v2'], function () {
    Route::get('/', function () { abort(404); });

    $parts = scandir(__DIR__);

    foreach($parts as $part) {
        if (str_contains($part, '__')) continue;
        if ($part == '.' || $part == '..') continue;
        if ($part == 'index.php') continue;
        if (!is_file(__DIR__ . "/$part")) continue;

        require __DIR__ . "/$part";

    }
});
