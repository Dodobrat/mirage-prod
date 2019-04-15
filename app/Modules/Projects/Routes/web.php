<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    //'middleware' => \Administration::routeMiddleware()
], function () {
    Route::group([
        'prefix' => 'projects',
        'as' => 'projects.'
    ], function () {

        Route::post('/ajax/getProject', [
            'as' => 'getProject',
            'uses' => 'ProjectsController@getProject'
        ]);
    });
});
