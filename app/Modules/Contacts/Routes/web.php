<?php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    //'middleware' => \Administration::routeMiddleware()
], function () {
    Route::group([
        'prefix' => 'contacts',
        'as' => 'contacts.'
    ], function () {
        Route::get('/', [
            'as' => 'index',
            'uses' => 'ContactsController@index'
        ]);

        Route::post('/', [
            'as' => 'store',
            'uses' => 'ContactsController@store'
        ]);
    });
});

