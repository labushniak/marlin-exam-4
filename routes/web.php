<?php

use Illuminate\Support\Facades\Route;


Route::get('/register', 'UsersController@registrationShowForm');
Route::post('/register', 'UsersController@registrationPostHandler');

Route::get('/login', 'UsersController@loginShowForm')->name('login');
Route::post('/login', 'UsersController@loginPostHandler')->name('login');

Route::get('/', function () {
    return view('users');
});





Route::get('/create', function () {
    return view('create');
});

Route::get('/edit', function () {
    return view('edit');
});

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');

Route::get('/security', function () {
    return view('security');
});

Route::get('/status', function () {
    return view('status');
});

Route::get('/avatar', function () {
    return view('avatar');
});

Route::get('/test', 'UsersController@index');

