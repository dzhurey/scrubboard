<?php

Route::get('/', 'VehicleController@index')->name('vehicle.index');
Route::get('/create', 'VehicleController@create')->name('vehicle.create');
// Route::post('/', 'VehicleController@store')->name('vehicle.store');
// Route::get('/{person}/edit', 'VehicleController@edit')->name('vehicle.edit');
// Route::put('/{person}/update', 'VehicleController@update')->name('vehicle.update');
// Route::delete('/{person}/destroy', 'VehicleController@destroy')->name('vehicle.destroy');
