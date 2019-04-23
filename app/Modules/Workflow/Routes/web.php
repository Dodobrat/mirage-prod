<?php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    //'middleware' => \Administration::routeMiddleware()
], function () {
    Route::group([
        'prefix' => 'workflow',
        'as' => 'workflow.'
    ], function () {
        Route::get('/{slug}', [
            'as' => 'index',
            'uses' => 'WorkflowController@index'
        ]);
    });
});

