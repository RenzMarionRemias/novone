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
    return view('welcome');
});

//Renz's Routes
Route::get('/', 'ClientController@showHomepage');
Route::get('/login', 'ClientController@showLogin');
Route::get('/signup', 'ClientController@showSignup');
Route::post('/client/register', 'ClientController@clientSignup');
Route::post('/client/profile', 'ClientController@showProfile');
Route::post('/client/signin', 'ClientController@clientSignin');
Route::post('/client/approve/{id}', 'ClientController@clientApprove');
Route::get('/client/logout', 'ClientController@logout');


Route::get('/products', 		   'ProductController@displayProductList');
Route::get('/products/{category}', 'ProductController@filterByCategory');

Route::get('/account/settings',				'ClientController@showUserInformation');
Route::get('/account/settings/credentials',	'ClientController@showChangeCredentials');
Route::post('/account/update', 				'ClientController@updateClientInformation');
Route::post('/account/update/email', 		'ClientController@updateEmail');
Route::post('/account/update/password', 	'ClientController@updatePassword');

// CART
Route::get('/cart/user','CartController@showCart');
Route::post('/cart/add', 'CartController@addProductToCart');
Route::get('/cart/delete/{id}','CartController@deleteItemToCart');
Route::post('/cart/payment', 'CartController@proceedPayment');
Route::get('/cart/payment/success','CartController@paymentSuccess');
Route::get('/payment/add-funds/paypal/status', 'CartController@getPaymentStatus');

Route::get('/order/details/{id}', 'CartController@getOrderDetails');
//End


//Admin

// Users ( Admin )
Route::get('/admin',           'AdminController@adminLogin');
Route::post('/admin/login',    'AdminController@submitLogin');
Route::get('/admin/dashboard','AdminController@showDashboard');
Route::get('/admin/dashboard/user/create','AdminController@showCreateUsers');
Route::get('/admin/dashboard/user/list','AdminController@showUsers');

Route::post('/admin/user/create',   'AdminController@createUser');
Route::post('/admin/user/update',   'AdminController@updateUser');
Route::get('/admin/user/list',      'AdminController@showUser');
Route::get('/admin/logout',         'AdminController@logoutUser');
Route::get('/admin/user/{status}/{id}', 'AdminController@updateUserStatus');

Route::get('/admin/dashboard/user/update/password',      'AdminController@showChangePassword');
Route::post('/admin/user/update/password',      'AdminController@saveNewPassword');

// Clients 
Route::get('/admin/client/list',  'ClientController@showClients');
Route::get('/admin/client/update/type/{id}','ClientController@changeAccountType');

// Sales
Route::get('/admin/invoice/list','CartController@showInvoice');
Route::get('/admin/invoice/{id}','CartController@showInvoiceDetails');
Route::get('/admin/transaction/update','CartController@updateTransaction');

// Products
Route::get('/admin/product/add',  'ProductController@addProduct');
Route::post('/admin/product/add', 'ProductController@saveNewProduct');
Route::get('/admin/product/delete/{productId}', 'ProductController@deleteProduct');
Route::get('/admin/product/edit', 'ProductController@showProducts');
Route::post('/admin/product/update', 'ProductController@updateProducts');
Route::post('/admin/product/search', 'ProductController@searchProducts');
// ---------------------------------------- //
// CATEGORY ROUTES
Route::get('/admin/category/add', 'CategoryController@addCategory');
Route::post('/admin/category/add', 'CategoryController@saveNewCategory');
Route::post('/admin/category/update', 'CategoryController@updateCategory');
Route::get('/admin/category/edit', 'CategoryController@showCategory');
Route::get('/admin/category/delete/{categoryId}', 'CategoryController@deleteCategory');
// ---------------------------------------- //

Route::get('/admin/inventory/add', 'InventoryController@addInventory');
Route::get('/admin/inventory/pull_in', 'InventoryController@showPullInProducts');
Route::get('/admin/inventory/pull_out', 'InventoryController@showPullOutProducts');
Route::post('/admin/inventory/update/quantity', 'InventoryController@updateQuantity');
Route::post('/admin/inventory/update/critical', 'InventoryController@updateCriticalValue');

Route::get('/admin/inventory/list', 'InventoryController@showInventory');

// STORES
Route::get('/admin/stores/list',  	  'StoreController@showStoreProducts');
Route::post('/admin/stores/pullout',  'StoreController@pullOutStoreProducts');

// ACCOUNT TYPE
Route::get('/admin/account/type/create',  'AccountController@createAccountType');
Route::post('/admin/account/type/create', 'AccountController@saveAccountType');
Route::get('/admin/account/type/{action}/{id}', 'AccountController@updateAccountStatus');


// MEASUREMENT
Route::get('/admin/measurement','MeasurementController@showMeasurement');
Route::post('/admin/measurement/new','MeasurementController@saveNewMeasurement');
Route::post('/admin/measurement/update','MeasurementController@updateMeasurementInfo');
Route::get('/admin/measurement/{active}/{id}','MeasurementController@updateMeasurementStatus');

// LOGS
Route::get('/admin/logs/user', 'LogsController@showUserLogs');

Route::get('/clear',function(){
	Artisan::call('cache:clear');
	dd('done!');
});


// PDF

Route::get('/products/download/pdf','ProductController@downloadProductList');

Route::get('/dump',function(){
	Artisan::call('cache:clear');
	exec('composer dump-autoload complete');
	dd('Clearing Done!!');
});

