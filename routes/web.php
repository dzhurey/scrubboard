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
Route::middleware('web')->resource('sales_invoices', 'SalesInvoiceController');
Route::middleware('web')->resource('payments', 'PaymentController');
Route::middleware('web')->resource('payment_means', 'PaymentMeanController');
Route::middleware('web')->resource('pickup_schedules', 'PickupScheduleController');
Route::middleware('web')->resource('delivery_schedules', 'DeliveryScheduleController');
Route::middleware('web')->resource('brands', 'BrandController');
Route::middleware('web')->resource('courier_schedules', 'CourierScheduleController')->only(['index']);
Route::middleware('web')->resource('promo', 'PromoController');

Route::namespace('Courier')->prefix('courier')->group(function () {
    Route::middleware('web')->resource('delivery_schedules', 'CourierDeliveryScheduleController', ['as' => 'courier', 'parameters' => ['delivery_schedules' => 'delivery_schedule']])->only(['index', 'edit']);
    Route::middleware('web')->resource('pickup_schedules', 'CourierPickupScheduleController', ['as' => 'courier', 'parameters' => ['pickup_schedules' => 'pickup_schedule']])->only(['index', 'edit']);
});
