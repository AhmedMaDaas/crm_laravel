<?php

Route::group(['prefix'=>'/', 'namespace' => 'User'], function(){

	Route::group(['prefix'=>'/users'], function(){

		Route::post('/login','UsersAPIAuthController@login');

		Route::post('/register','UsersAPIAuthController@register');

		Route::group(['middleware' => 'auth:sanctum'], function(){

			Route::post('/logout','UsersAPIAuthController@logout');

			Route::post('/change-password','UsersAPIAuthController@changPassword');

		});

	});

});