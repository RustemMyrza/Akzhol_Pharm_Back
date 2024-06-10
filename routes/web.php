<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'redirectAdminIndex'])->middleware('auth');
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/language/switch', [\App\Http\Controllers\HomeController::class, 'languageSwitch'])->name('languageSwitch');

Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@index')->name('register');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@registerUser')->name('registerUser');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

