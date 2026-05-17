<?php

use Illuminate\Http\Request;


// Under Construction
Route::group([
    'as' => 'api.settings.under_construction.', 
    'middleware' => 'auth:api',
    'prefix' => 'under_construction'
], function () {

    Route::get('under_construction', 'Api\UnderConstructionController@index')->name('index');

    Route::post('under_construction', 'Api\UnderConstructionController@store')->name('store');

});

