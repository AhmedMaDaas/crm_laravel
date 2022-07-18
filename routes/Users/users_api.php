<?php

Route::group(['prefix' => '/users', 'namespace' => 'User', 'middleware' => ['auth:sanctum', 'admin']],function(){

	// user route
    Route::get('/','UsersAPIController@index');
    Route::get('/profile','UsersAPIController@userProfile');
    Route::get('/show','UsersAPIController@show');
    Route::post('/create','UsersAPIController@create');
    Route::post('/update','UsersAPIController@update');
    Route::delete('/destroy','UsersAPIController@destroy');

});