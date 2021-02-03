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

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/create', function () {
        return view('create');
    })->name('create')->middleware('admin');
});

Route::get('/edit/{id?}', function ($id = null) {
    if ($id){
        return view('edit');
    }
    return redirect('/');
})->name('edit');



Route::get('/security', function () {
    return view('security');
})->name('security');

Route::get('/status', function () {
    return view('status');
})->name('status');

Route::get('/avatar', function () {
    return view('avatar');
})->name('avatar');

Route::get('/delete', function () {
    
})->name('delete');

Route::get('/test', 'UsersController@test');

