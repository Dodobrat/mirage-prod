<?php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    //'middleware' => \Administration::routeMiddleware()
], function () {
    Route::group([
        'prefix' => 'team',
        'as' => 'team.'
    ], function () {
        Route::get('/', [
            'as' => 'index',
            'uses' => 'TeamController@index'
        ]);
    });
});
