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
], function () {
    Route::group([
        'prefix' => 'type',
        'as' => 'type.',
    ], function () {
        Route::get('/{slug}', [
            'as' => 'index',
            'uses' => 'TypesController@index'
        ]);
        Route::post('/ajax/getProjects', [
            'as' => 'getProjects',
            'uses' => 'TypesController@getProjects'
        ]);
    });
});

