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

Route::get('/', 'IndexController@handle');

Route::get('/register', 'AuthController@showRegister');

Route::post('/register', 'AuthController@storeRegister');

Route::get('/login', 'AuthController@showLogin');

Route::post('/login', 'AuthController@storeLogin');

Route::get('/logout', 'AuthController@logout') -> middleware('checkAuthorization');

Route::middleware(['checkAuthorization']) -> prefix('user')->group(function () {

  Route::get('profile', 'UserController@showProfile');

  Route::patch('profile', 'UserController@storeProfile');

  Route::get('orders-history', 'UserController@ordersHistory');

  Route::get('update-password', 'UserController@showUpdatePassword');

  Route::patch('update-password', 'UserController@storeUpdatePassword');

});

Route::middleware(['checkAuthorization']) -> prefix('inventory') -> group(function () {

  Route::get('product', 'Inventory\ProductController@showProducts');

  Route::patch('product', 'Inventory\ProductController@storeProducts');

  Route::get('product/product', 'Inventory\ProductController@showAddNewProduct');

  Route::post('product/product', 'Inventory\ProductController@storeAddNewProduct');

  Route::get('product/{id}', 'Inventory\ProductController@showProduct');

  Route::post('product/{id}', 'Inventory\ProductController@storeCategory');

  Route::put('product/{id}', 'Inventory\ProductController@storeProduct');

});

Route::middleware(['checkAuthorization']) -> prefix('shop')->group(function () {

  Route::get('search', 'Shop\SearchController@handle');

  Route::get('category', 'Shop\CategoryController@showCategories');

  Route::get('category/{id}', 'Shop\CategoryController@showCategory');

  Route::get('product', 'Shop\ProductController@showProducts');

  Route::get('product/{id}', 'Shop\ProductController@showProduct');

  Route::patch('product/{id}/addToCart', 'Shop\ProductController@addToCart');

  Route::patch('product/{id}/removeFromCart', 'Shop\ProductController@removeFromCart');

  Route::patch('product/{id}/setCartQuantity', 'Shop\ProductController@setCartQuantity');

  Route::patch('product/{id}/increaseCartQuantity', 'Shop\ProductController@increaseCartQuantity');

  Route::patch('product/{id}/decreaseCartQuantity', 'Shop\ProductController@decreaseCartQuantity');

  Route::patch('product/{id}/setRating', 'Shop\ProductController@setRating');

});

Route::middleware(['checkAuthorization']) -> prefix('checkout')->group(function () {

  Route::get('cart', 'Shop\CheckoutController@cart');

  Route::get('checkout', 'Shop\CheckoutController@showCheckout');

  Route::post('checkout', 'Shop\CheckoutController@storeCheckout');

  Route::get('thank-you', 'Shop\CheckoutController@thankYou');

});
