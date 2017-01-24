<?php

// authentication routes...
Auth::routes();
Route::get('/token/{token}', 'TokensController@token');

// Welcome route...
Route::get('/', function () {
    return view('welcome');
});

// dashboard route...
Route::get('/dashboard', 'DashboardController@index');

// settings routes...
Route::get('/settings/token', 'SettingsController@token');