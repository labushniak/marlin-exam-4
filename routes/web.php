<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'UsersController@home')->name('home');

Route::middleware('guest')->group(function(){
    
    Route::get('/register', 'UsersController@registrationShowForm')->name('registration');
    Route::post('/register', 'UsersController@registrationPostHandler')->name('registration.create');

    Route::get('/login', 'UsersController@loginShowForm')->name('login');
    Route::post('/login', 'UsersController@loginPostHandler')->name('login.create');
});



Route::middleware('auth')->group(function(){

    Route::get('/logout', 'UsersController@logout')->name('logout');

    Route::get('/profile/{id?}', 'UsersController@showProfile')->name('profile');

    Route::get('/create', 'UsersController@createShowForm')->name('create.form')->middleware('admin');
    Route::post('/create', 'UsersController@createPostHandler')->name('create.action')->middleware('admin');

    Route::get('/edit/{id?}', 'UsersController@editShowForm')->name('edit.form');
    Route::post('/edit/{id?}', 'UsersController@editPostHandler')->name('edit.action');

    Route::get('/security/{id?}', 'UsersController@securityShowForm')->name('security.form');
    Route::post('/security/{id?}', 'UsersController@securityPostHandler')->name('security.action');

    Route::get('/status/{id?}', 'UsersController@statusShowForm')->name('status.form');
    Route::post('/status/{id?}', 'UsersController@statusPostHandler')->name('status.action');

    Route::get('/avatar/{id?}', 'UsersController@avatarShowForm')->name('avatar.form');
    Route::post('/avatar/{id?}', 'UsersController@avatarPostHandler')->name('avatar.action');

    Route::get('/delete/{id?}', 'UsersController@delete')->name('delete');
});