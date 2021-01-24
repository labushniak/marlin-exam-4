<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('users');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/create', function () {
    return view('create');
});

Route::get('/edit', function () {
    return view('edit');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/security', function () {
    return view('security');
});

Route::get('/status', function () {
    return view('status');
});

Route::get('/avatar', function () {
    return view('avatar');
});