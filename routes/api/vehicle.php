<?php

Route::get('/', 'VehicleController@index');
Route::get('/create', 'VehicleController@create');
Route::post('/', 'VehicleController@store');
Route::get('/{vehicle}', 'VehicleController@show');
Route::get('/{vehicle}/edit', 'VehicleController@edit');
Route::put('/{vehicle}/update', 'VehicleController@update');
Route::delete('/{vehicle}/destroy', 'VehicleController@destroy');
