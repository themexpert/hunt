<?php

// authentication routes...
Route::get('/token/{token}', 'TokensController@token');
Route::get('/auth/google', 'Api\Auth\LoginController@redirectToProvider');
Route::get('/auth/google/callback', 'Api\Auth\LoginController@handleProviderCallback');

// dashboard route...
Route::get('/dashboard', 'DashboardController@index');

// settings routes...
Route::get('/settings/token', 'SettingsController@token');



// SPA Starts...
//Route::get('/', function () {
//    return view('main-app');
//});

Route::get('/refreshToken', function () {
    return response()->json(
        [
            'loggedIn' => true,
            'token'    => auth()->user()->createToken('laravel_token')->accessToken,
            '_token'   => csrf_token(),
            'user'     => [
                'name'  => auth()->user()->name,
                'email' => auth()->user()->email
            ],
            'is_developer' => \Hunt\User::developer(auth()->user()->email)
        ]
    );
})->middleware('auth');


Route::get('/refresh', function(){
    return response()->json([
                                'loggedIn' => auth()->check(),
                                '_token' => csrf_token()
                            ]);
})->name('refresh');

Route::get('/logout', 'Api\Auth\LoginController@logout');

Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function() {
    Auth::routes();
});

Route::any('{slug}', function($slug)
{
    return view('main-app');
})->where('slug', '([A-z\d-\/_.]+)?');





