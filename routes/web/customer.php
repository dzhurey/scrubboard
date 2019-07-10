<?php

Route::get('/', 'CustomerController@index')->name('customers.index');
Route::get('/create', 'CustomerController@create')->name('customers.create');
// Route::post('/', 'CustomerController@store')->name('customers.store');
// Route::get('/{customer}/edit', 'CustomerController@edit')->name('customers.edit');
// Route::put('/{customer}/update', 'CustomerController@update')->name('customers.update');
// Route::delete('/{customer}/destroy', 'CustomerController@destroy')->name('customers.destroy');
