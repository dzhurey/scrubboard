<?php

Route::get('/', 'ItemController@index')->name('items.index');
Route::get('/create', 'ItemController@create')->name('items.create');
Route::post('/', 'ItemController@store')->name('items.store');
Route::get('/{item}', 'ItemController@show')->name('items.show');
Route::get('/{item}/edit', 'ItemController@edit')->name('items.edit');
Route::put('/{item}/update', 'ItemController@update')->name('items.update');
Route::delete('/{item}/destroy', 'ItemController@destroy')->name('items.destroy');
