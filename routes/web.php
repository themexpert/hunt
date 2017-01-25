<?php


// authentication routes...
Route::get('/token/{token}', 'TokensController@token');
Route::get('/auth/google', 'Auth\LoginController@redirectToProvider');
Route::get('/auth/google/callback', 'Auth\LoginController@handleProviderCallback');

// dashboard route...
Route::get('/dashboard', 'DashboardController@index');

// settings routes...
Route::get('/settings/token', 'SettingsController@token');



// SPA Starts...
//Route::get('/', function () {
//    return view('main-app');
//});

Route::get('/test', function () {
    return "test";
})->middleware('auth');

Route::get('/profile', function(){
    return response()->json([
        'user' => [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email
        ]
    ]);
})->middleware('auth');

Route::group(['prefix' => 'auth', 'namespace' => 'api'], function() {
    Auth::routes();
});

Route::any('{slug}', function($slug)
{
    return view('main-app');
})->where('slug', '([A-z\d-\/_.]+)?');





