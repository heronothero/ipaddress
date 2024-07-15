<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::get('/registration', function () {
    return view('registration');
});

Route::get('/authorization', function () {
    return view('authorization');
});
