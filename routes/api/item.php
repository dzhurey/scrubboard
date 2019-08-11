<?php

Route::get('/', 'ItemController@index');
Route::get('/create', 'ItemController@create');
Route::post('/', 'ItemController@store');
Route::get('/{item}', 'ItemController@show');
Route::get('/{item}/edit', 'ItemController@edit');
Route::put('/{item}/update', 'ItemController@update');
Route::delete('/{item}/destroy', 'ItemController@destroy');
