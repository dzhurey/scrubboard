<?php

Route::get('/', 'BankAccountController@index');
Route::get('/create', 'BankAccountController@create');
Route::post('/', 'BankAccountController@store');
Route::get('/{bank_account}/edit', 'BankAccountController@edit');
Route::put('/{bank_account}/update', 'BankAccountController@update');
Route::delete('/{bank_account}/destroy', 'BankAccountController@destroy');
Route::get('/{bank_account}', 'BankAccountController@show');
