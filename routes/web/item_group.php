<?php

Route::get('/', 'ItemGroupController@index')->name('item_groups.index');
Route::get('/create', 'ItemGroupController@create')->name('item_groups.create');
Route::post('/', 'ItemGroupController@store')->name('item_groups.store');
Route::get('/{item_group}/edit', 'ItemGroupController@edit')->name('item_groups.edit');
Route::put('/{item_group}/update', 'ItemGroupController@update')->name('item_groups.update');
Route::delete('/{item_group}/destroy', 'ItemGroupController@destroy')->name('item_groups.destroy');
