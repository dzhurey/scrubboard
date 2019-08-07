<?php

Route::get('/', 'VehicleController@index')->name('vehicles.index');
Route::get('/create', 'VehicleController@create')->name('vehicles.create');
Route::post('/', 'VehicleController@store')->name('vehicles.store');
Route::get('/{vehicle}', 'VehicleController@show')->name('vehicles.show');
Route::get('/{vehicle}/edit', 'VehicleController@edit')->name('vehicles.edit');
Route::put('/{vehicle}/update', 'VehicleController@update')->name('vehicles.update');
Route::delete('/{vehicle}/destroy', 'VehicleController@destroy')->name('vehicles.destroy');
