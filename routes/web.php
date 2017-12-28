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
Route::post('/client/signin', 'ClientController@clientSignin');
Route::post('/client/approve/{id}', 'ClientController@clientApprove');
Route::get('/client/logout', 'ClientController@logout');

Route::get('/products', 'ProductController@displayProductList');
Route::get('/products/{category}', 'ProductController@filterByCategory');

// CART
Route::get('/cart/user','CartController@showCart');
Route::post('/cart/add', 'CartController@addProductToCart');
Route::get('/cart/delete/{id}','CartController@deleteItemToCart');
Route::post('/cart/payment', 'CartController@proceedPayment');
Route::get('/cart/payment/success','CartController@paymentSuccess');
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

Route::get('/admin/user/update/password',      'AdminController@showChangePassword');
//Route::post('/admin/user/update/password',      'AdminController@saveNewPassword');

// Clients 
Route::get('/admin/client/list',  'ClientController@showClients');

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
Route::post('/admin/inventory/update/quantity', 'InventoryController@updateQuantity');
Route::post('/admin/inventory/update/critical', 'InventoryController@updateCriticalValue');

Route::get('/admin/inventory/list', 'InventoryController@showInventory');

