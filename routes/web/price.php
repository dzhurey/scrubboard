<?php

Route::get('/', 'PriceController@index')->name('prices.index');
Route::get('/create', 'PriceController@create')->name('prices.create');
Route::post('/', 'PriceController@store')->name('prices.store');
Route::get('/{price}', 'PriceController@show')->name('prices.show');
Route::get('/{price}/edit', 'PriceController@edit')->name('prices.edit');
Route::put('/{price}/update', 'PriceController@update')->name('prices.update');
Route::delete('/{price}/destroy', 'PriceController@destroy')->name('prices.destroy');
