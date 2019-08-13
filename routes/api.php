<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Auth\LoginController@loginApi');

Route::middleware('auth:api')->resource('customers', 'CustomerController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('people', 'PersonController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('vehicles', 'VehicleController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('bank_accounts', 'BankAccountController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('couriers', 'CourierController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('item_groups', 'ItemGroupController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('item_sub_categories', 'ItemSubCategoryController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('items', 'ItemController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('prices', 'PriceController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('agents', 'AgentController', ['as' => 'api'])->except(['create', 'edit']);
