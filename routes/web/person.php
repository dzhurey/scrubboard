<?php

Route::get('/', 'PersonController@index')->name('people.index');
Route::get('/create', 'PersonController@create')->name('people.create');
Route::post('/', 'PersonController@store')->name('people.store');
Route::get('/{person}/edit', 'PersonController@edit')->name('people.edit');
Route::put('/{person}/update', 'PersonController@update')->name('people.update');
Route::delete('/{person}/destroy', 'PersonController@destroy')->name('people.destroy');
