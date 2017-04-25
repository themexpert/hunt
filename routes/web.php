<?php

// authentication routes...
Route::get('/token/{token}', 'TokensController@token');
Route::get('/auth/google', 'Api\Auth\LoginController@redirectToProvider');
Route::get('/auth/google/callback', 'Api\Auth\LoginController@handleProviderCallback');

// dashboard route...
Route::get('/dashboard', 'DashboardController@index');

// SPA Starts...
//Route::get('/', function () {
//    return view('main-app');
//});

Route::get('/refresh-token', function () {
    $tokens = auth()->user()->tokens;
    if($tokens->count()) $tokens->map(function($token){
        $token->delete();
    });
    $token = auth()->user()->createToken('hunt_api_token')->accessToken;
    return response()->json(
        [
            'loggedIn' => true,
            'token'    => $token,
            '_token'   => csrf_token(),
            'user'     => [
                'name'  => auth()->user()->name,
                'email' => auth()->user()->email,
                'is_admin' => \Hunt\User::developer(auth()->user()->email)
            ]
        ]
    );
})->middleware('auth');

/**
 * Temporary route....
 */
Route::get('/key', function() {
   return auth()->user()->createToken('laravel_token')->accessToken;
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
    $settings = \Hunt\Setting::find(1);
    return view('main-app', compact('settings'));
})->where('slug', '([A-z\d-\/_.]+)?');





