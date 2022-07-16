<?php

Route::group(['prefix' => 'product', 'namespace' => 'Product', 'middleware' => ['auth']],function(){

	// product route
    Route::get('/','ProductsController@index')->name('product.index');

	Route::group(['middleware' => ['admin']], function(){

		Route::get('/user','ProductsController@userProducts')->name('user.product');
		Route::get('/edit','ProductsController@edit')->name('product.edit');
	    Route::get('/create','ProductsController@create')->name('product.create');
	    Route::post('/store','ProductsController@store')->name('product.store');
	    Route::put('/update','ProductsController@update')->name('product.update');
	    Route::delete('/destroy','ProductsController@destroy')->name('product.destroy');

	});

});