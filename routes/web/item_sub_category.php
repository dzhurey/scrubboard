<?php

Route::get('/', 'ItemSubCategoryController@index')->name('item_sub_categories.index');
Route::get('/create', 'ItemSubCategoryController@create')->name('item_sub_categories.create');
Route::post('/', 'ItemSubCategoryController@store')->name('item_sub_categories.store');
Route::get('/{item_sub_category}', 'ItemSubCategoryController@show')->name('item_sub_categories.show');
Route::get('/{item_sub_category}/edit', 'ItemSubCategoryController@edit')->name('item_sub_categories.edit');
Route::put('/{item_sub_category}/update', 'ItemSubCategoryController@update')->name('item_sub_categories.update');
Route::delete('/{item_sub_category}/destroy', 'ItemSubCategoryController@destroy')->name('item_sub_categories.destroy');
