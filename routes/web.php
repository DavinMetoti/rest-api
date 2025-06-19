<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    // return a login view or message
    return 'Login page placeholder';
})->name('login');
