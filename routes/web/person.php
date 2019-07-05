<?php

Route::get('/', 'PersonController@index')->name('user_index');
Route::get('/create', 'PersonController@create')->name('user_create');
Route::post('/', 'PersonController@store')->name('user_store');
