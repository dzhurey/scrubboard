<?php

Route::get('/', 'PersonController@index')->name('people_index');
Route::get('/create', 'PersonController@create')->name('people_create');
Route::post('/', 'PersonController@store')->name('people_store');
