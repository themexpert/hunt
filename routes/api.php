<?php

/******************************************************************************************
 *
 * Headers for cors.
 *
 *****************************************************************************************/
if(app()->environment() !== 'testing') {
    header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
}

Route::group(['namespace' => 'Api'], function() {

    // products routes...
    Route::get('/products', 'ProductsController@index');
    Route::post('/products', 'ProductsController@add');
    Route::get('/products/{id}', 'ProductsController@show');
    Route::delete('/products/{id}', 'ProductsController@remove');
    Route::post('/products/{id}', 'ProductsController@update');
    Route::get('/products/{id}/suggests', 'ProductsController@suggests');

    // features routes...
    Route::get('/products/{productId}/features', 'FeaturesController@index');
    Route::post('/products/{productId}/features', 'FeaturesController@add');
    Route::get('/products/{productId}/features/{id}', 'FeaturesController@show');
    Route::delete('/products/{productId}/features/{id}', 'FeaturesController@remove');
    Route::post('/products/{productId}/features/{id}', 'FeaturesController@update');

    // released features route...
    Route::get('/features/released', 'FeaturesController@released');

    // search route..
    Route::get('/search', 'FeaturesController@search');

    // comments routes...
    Route::get('/features/{featureId}/comments', 'CommentsController@index');
    Route::post('/features/{featureId}/comments', 'CommentsController@add');
    Route::get('/features/{featureId}/comments/{commentId}', 'CommentsController@show');
    Route::delete('/features/{featureId}/comments/{commentId}', 'CommentsController@remove');
    Route::post('/features/{featureId}/comments/{commentId}', 'CommentsController@update');

    // status routes...
    Route::get('/statuses', 'StatusesController@all');

    // releases route...
    Route::post('/releases/{featureId}', 'ReleasesController@releaseNewFeature');

    // declines route...
    Route::post('/declines/{featureId}', 'DeclinesController@declineFeature');

    // plans route...
    Route::post('/plans/{featureId}', 'PlansController@planFeature');

    // votes routes...
    Route::post('/votes/{featureId}/up', 'VotesController@up');
    Route::post('/votes/{featureId}/down', 'VotesController@down');

    // priorities routes...
    Route::post('/priorities/{featureId}', 'PrioritiesController@update');

    // development efforts routes...
    Route::post('/efforts/{featureId}', 'EffortsController@update');

    // filters routes...
    Route::get('/filters/access/{filterBy}', 'FiltersController@byAccess');
    Route::get('/filters/tags/{tagId}', 'FiltersController@byTag');

    // prepared reports routes...
    Route::get('/prepared-reports/{type}', 'PreparedReportsController@byType');

    // tags routes...
    Route::get('/tags', 'TagsController@all');

    // users routes...
    Route::get('/users/{id}/suggests', 'UsersController@suggests');
});