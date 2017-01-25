<?php

// authentication routes...
Auth::routes();
Route::get('/token/{token}', 'TokensController@token');
Route::get('/auth/google', 'Auth\LoginController@redirectToProvider');
Route::get('/auth/google/callback', 'Auth\LoginController@handleProviderCallback');

// dashboard route...
Route::get('/dashboard', 'DashboardController@index');

// settings routes...
Route::get('/settings/token', 'SettingsController@token');



// SPA Starts...
Route::get('/', function () {
    return view('main-app');
});

Route::get('/refresh', function(){
    return response()->json([
        'loggedIn' => auth()->check(),
        '_token' => csrf_token()
    ]);
})->name('refresh');

Route::get('/profile', function(){
    return response()->json([
        'user' => [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email
        ]
    ]);
});

Route::any('{slug}', function($slug)
{
    return view('main-app');
})->where('slug', '([A-z\d-\/_.]+)?');

