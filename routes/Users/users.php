<?php

Route::group(['prefix' => '/users', 'namespace' => 'User', 'middleware' => ['auth']],function(){
    
    Route::get('/profile','UsersController@userProfile')->name('users.profile');

	// user route
	Route::group(['middleware' => ['admin']], function(){
		Route::get('/','UsersController@index')->name('users.index');
	    Route::get('/show','UsersController@show')->name('users.show');
	    Route::get('/edit','UsersController@edit')->name('users.edit');
	    Route::get('/create','UsersController@create')->name('users.create');
	    Route::post('/store','UsersController@store')->name('users.store');
	    Route::put('/update','UsersController@update')->name('users.update');
	    Route::delete('/destroy','UsersController@destroy')->name('users.destroy');
	});

});