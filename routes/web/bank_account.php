<?php

Route::get('/', 'BankAccountController@index')->name('bank_accounts.index');
Route::get('/create', 'BankAccountController@create')->name('bank_accounts.create');
Route::post('/', 'BankAccountController@store')->name('bank_accounts.store');
Route::get('/{bank_account}/edit', 'BankAccountController@edit')->name('bank_accounts.edit');
Route::put('/{bank_account}/update', 'BankAccountController@update')->name('bank_accounts.update');
Route::delete('/{bank_account}/destroy', 'BankAccountController@destroy')->name('bank_accounts.destroy');
