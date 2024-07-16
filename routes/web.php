<?php
declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});
Route::get('/registration', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/registration', [RegisterController::class, 'register']);
Route::get('/authorization', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/authorization', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
