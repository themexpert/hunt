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

Route::get('/test', function () {
    return "test";
})->middleware('auth');


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
})->middleware('auth');

Route::get('/logout', 'Api\Auth\LoginController@logout');

Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function() {
    Auth::routes();
});

Route::any('{slug}', function($slug)
{
    return view('main-app');
})->where('slug', '([A-z\d-\/_.]+)?');





