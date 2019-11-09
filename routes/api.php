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

Route::post('/order', 'Api\OrderController@createOrder');
Route::get('/order/{id}', 'Api\OrderController@getOrder');
Route::put('/order/{id}/order_items', 'Api\OrderController@changeOrderItems');
Route::put('/order/{id}/status', 'Api\OrderController@changeOrderStatus');
Route::delete('/order/{id}', 'Api\OrderController@cancelOrder');

