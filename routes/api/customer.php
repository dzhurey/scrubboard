<?php

Route::get('/', 'CustomerController@index');
Route::get('/create', 'CustomerController@create');
Route::post('/', 'CustomerController@store');
Route::get('/{customer}', 'CustomerController@show');
Route::get('/{customer}/edit', 'CustomerController@edit');
Route::put('/{customer}/update', 'CustomerController@update');
Route::delete('/{customer}/destroy', 'CustomerController@destroy');
