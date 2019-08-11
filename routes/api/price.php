<?php

Route::get('/', 'PriceController@index');
Route::get('/create', 'PriceController@create');
Route::post('/', 'PriceController@store');
Route::get('/{price}', 'PriceController@show');
Route::get('/{price}/edit', 'PriceController@edit');
Route::put('/{price}/update', 'PriceController@update');
Route::delete('/{price}/destroy', 'PriceController@destroy');
