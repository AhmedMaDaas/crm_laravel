<?php

Route::group(['prefix' => '/users', 'namespace' => 'User', 'middleware' => ['auth:sanctum']],function(){

	// user route
    Route::get('/profile','UsersAPIController@userProfile');

    Route::group(['middleware' => ['admin']], function(){
		Route::get('/','UsersAPIController@index');
	    Route::get('/show','UsersAPIController@show');
	    Route::post('/create','UsersAPIController@create');
	    Route::post('/update','UsersAPIController@update');
	    Route::delete('/destroy','UsersAPIController@destroy');
	});

});