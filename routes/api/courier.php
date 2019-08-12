<?php

Route::get('/', 'CourierController@index');
Route::get('/create', 'CourierController@create');
Route::post('/', 'CourierController@store');
Route::get('/{courier}', 'CourierController@show');
Route::get('/{courier}/edit', 'CourierController@edit');
Route::put('/{courier}/update', 'CourierController@update');
Route::delete('/{courier}/destroy', 'CourierController@destroy');
