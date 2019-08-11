<?php

Route::get('/', 'ItemSubCategoryController@index');
Route::get('/create', 'ItemSubCategoryController@create');
Route::post('/', 'ItemSubCategoryController@store');
Route::get('/{item_sub_category}', 'ItemSubCategoryController@show');
Route::get('/{item_sub_category}/edit', 'ItemSubCategoryController@edit');
Route::put('/{item_sub_category}/update', 'ItemSubCategoryController@update');
Route::delete('/{item_sub_category}/destroy', 'ItemSubCategoryController@destroy');
