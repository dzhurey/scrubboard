<?php

Route::get('/', 'UserController@index')->name('user_index');
Route::get('/create', 'UserController@create')->name('user_create');
