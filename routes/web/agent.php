<?php

Route::get('/', 'AgentController@index')->name('agents.index');
Route::get('/create', 'AgentController@create')->name('agents.create');
Route::post('/', 'AgentController@store')->name('agents.store');
Route::get('/{agent}', 'AgentController@show')->name('agents.show');
Route::get('/{agent}/edit', 'AgentController@edit')->name('agents.edit');
Route::put('/{agent}/update', 'AgentController@update')->name('agents.update');
Route::delete('/{agent}/destroy', 'AgentController@destroy')->name('agents.destroy');
