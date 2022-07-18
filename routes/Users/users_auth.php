<?php

Route::group(['prefix'=>'/', 'namespace' => 'User'], function(){

	Route::group(['middleware' => ['auth']], function(){
		// Password Change
	    Route::get('change-password', 'UsersAuthController@changePassword')->name('change.password.form');
	    Route::post('change-password', 'UsersAuthController@changPasswordStore')->name('change.password');
	});

	Route::group(['prefix'=>'/user'], function(){

		Route::get('/login','UsersAuthController@login')->name('login.form');
		Route::post('/login','UsersAuthController@loginSubmit')->name('login.submit');
		Route::any('/logout','UsersAuthController@logout')->name('user.logout');

		Route::get('/register','UsersAuthController@register')->name('register.form');
		Route::post('/register','UsersAuthController@registerSubmit')->name('register.submit');

	});

});