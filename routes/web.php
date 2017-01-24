<?php

// authentication routes...
Auth::routes();
Route::get('/token/{token}', 'TokensController@token');
Route::get('/auth/google', 'Auth\LoginController@redirectToProvider');
Route::get('/auth/google/callback', 'Auth\LoginController@handleProviderCallback');

// Welcome route...
Route::get('/', function () {
    return view('welcome');
});

// dashboard route...
Route::get('/dashboard', 'DashboardController@index');

// settings routes...
Route::get('/settings/token', 'SettingsController@token');

Route::get('/csrf', function() {
   return csrf_token();
});