<?php

Route::get('/', 'AgentController@index');
Route::get('/create', 'AgentController@create');
Route::post('/', 'AgentController@store');
Route::get('/{agent}', 'AgentController@show');
Route::get('/{agent}/edit', 'AgentController@edit');
Route::put('/{agent}/update', 'AgentController@update');
Route::delete('/{agent}/destroy', 'AgentController@destroy');
