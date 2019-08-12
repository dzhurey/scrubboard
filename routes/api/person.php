<?php

Route::get('/', 'PersonController@index');
Route::get('/create', 'PersonController@create');
Route::post('/', 'PersonController@store');
Route::get('/{person}', 'PersonController@shows');
Route::get('/{person}/edit', 'PersonController@edit');
Route::put('/{person}/update', 'PersonController@update');
Route::delete('/{person}/destroy', 'PersonController@destroy');
