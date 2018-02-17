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

Route::get('reports/sales','ReportController@filterSales');
Route::get('reports/clients','ReportController@filterClients');

Route::get('products/critical','ReportController@getCriticalLevelProducts');
Route::get('products/totalsales','ReportController@topProducts');

Route::get('notification/{userid}','NotificationController@getNotification');

Route::get('message/get','MessageController@getMessage');
Route::post('message/send','MessageController@sendMessage');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('invoice/{id}','CartController@showInvoiceDetails');