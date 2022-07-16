<?php

Route::group(['prefix'=>'/products', 'namespace' => 'Product', 'middleware' => ['auth:sanctum']], function(){

	Route::get('/index','ProductsAPIController@index');

	Route::get('/user','ProductsAPIController@userProducts');

	Route::get('/show','ProductsAPIController@show');

	Route::post('/create','ProductsAPIController@create');

	Route::post('/update','ProductsAPIController@update');

	Route::delete('/destroy','ProductsAPIController@destroy');
});