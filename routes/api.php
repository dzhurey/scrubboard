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
Route::middleware('auth:api')
->resource('couriers', 'CourierController', ['as' => 'api', 'parameters' => ['couriers' => 'person']])
->except(['create', 'edit']);
Route::middleware('auth:api')->resource('item_groups', 'ItemGroupController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('item_sub_categories', 'ItemSubCategoryController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('items', 'ItemController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('prices', 'PriceController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('agents', 'AgentController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('sales_orders', 'SalesOrderController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('sales_invoices', 'SalesInvoiceController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('payments', 'PaymentController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('payment_means', 'PaymentMeanController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('pickup_schedules', 'PickupScheduleController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('delivery_schedules', 'DeliveryScheduleController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('brands', 'BrandController', ['as' => 'api'])->except(['create', 'edit']);
Route::middleware('auth:api')->resource('courier_schedules', 'CourierScheduleController', ['as' => 'api'])->only(['index']);
Route::middleware('auth:api')->resource('addresses', 'AddressController', ['as' => 'api'])->except(['create', 'edit']);

// Courier only
Route::namespace('Courier')->prefix('courier')->group(function () {
    Route::middleware('auth:api')->resource('delivery_schedules', 'CourierDeliveryScheduleController', ['as' => 'api.courier', 'parameters' => ['delivery_schedules' => 'delivery_schedule']])->only(['index', 'show']);
    Route::middleware('auth:api')->resource('delivery_schedules', 'CourierDeliveryScheduleController', ['as' => 'api.courier', 'parameters' => ['delivery_schedules' => 'courier_schedule_line']])->only(['update']);
    Route::middleware('auth:api')->resource('pickup_schedules', 'CourierPickupScheduleController', ['as' => 'api.courier', 'parameters' => ['pickup_schedules' => 'pickup_schedule']])->only(['index', 'show']);
    Route::middleware('auth:api')->resource('pickup_schedules', 'CourierPickupScheduleController', ['as' => 'api.courier', 'parameters' => ['pickup_schedules' => 'courier_schedule_line']])->only(['update']);
});
