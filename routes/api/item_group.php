<?php

Route::get('/', 'ItemGroupController@index');
Route::get('/create', 'ItemGroupController@create');
Route::post('/', 'ItemGroupController@store');
Route::get('/{item_group}', 'ItemGroupController@show');
Route::get('/{item_group}/edit', 'ItemGroupController@edit');
Route::put('/{item_group}/update', 'ItemGroupController@update');
Route::delete('/{item_group}/destroy', 'ItemGroupController@destroy');
