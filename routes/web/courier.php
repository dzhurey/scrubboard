<?php

Route::get('/', 'CourierController@index')->name('couriers.index');
Route::get('/create', 'CourierController@create')->name('couriers.create');
Route::post('/', 'CourierController@store')->name('couriers.store');
Route::get('/{courier}/edit', 'CourierController@edit')->name('couriers.edit');
Route::put('/{courier}/update', 'CourierController@update')->name('couriers.update');
Route::delete('/{courier}/destroy', 'CourierController@destroy')->name('couriers.destroy');
