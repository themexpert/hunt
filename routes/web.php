<?php

// authentication routes...
Auth::routes();

// Welcome route...
Route::get('/', function () {
    return view('welcome');
});

// dashboard route...
Route::get('/dashboard', 'HomeController@index');

// settings routes...
Route::get('/settings/token', 'SettingsController@token');

