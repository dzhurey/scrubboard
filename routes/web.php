<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('web')->resource('customers', 'CustomerController');
Route::middleware('web')->resource('people', 'PersonController');
Route::middleware('web')->resource('vehicles', 'VehicleController');
Route::middleware('web')->resource('bank_accounts', 'BankAccountController');
Route::middleware('web')->resource('couriers', 'CourierController');
Route::middleware('web')->resource('item_groups', 'ItemGroupController');
Route::middleware('web')->resource('item_sub_categories', 'ItemSubCategoryController');
Route::middleware('web')->resource('items', 'ItemController');
Route::middleware('web')->resource('prices', 'PriceController');
Route::middleware('web')->resource('agents', 'AgentController');

Route::middleware('web')->resource('sales_orders', 'SalesOrderController');
