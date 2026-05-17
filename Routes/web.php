<?php

use Illuminate\Http\Request;


// Under Construction
Route::group([
    'as' => 'settings.under_construction.', 
    "middleware" => ["web","auth","role:admin|editor|analyzer|guest"],
], function () {

    Route::get('under_construction', 'UnderConstructionController@edit')->name('edit');

    Route::post('under_construction', 'UnderConstructionController@store')->name('store');

});

