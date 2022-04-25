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

Route::get('/register', 'AuthController@getRegister');

Route::post('/register', 'AuthController@postRegister');

Route::get('/login', 'AuthController@getLogin');

Route::post('/login', 'AuthController@postLogin');

Route::get('/logout', 'AuthController@logout') -> middleware('checkAuthorization');

Route::middleware(['checkAuthorization']) -> prefix('user')->group(function () {

  Route::get('profile', 'UserController@getProfile');

  Route::post('profile', 'UserController@postProfile');

  Route::get('orders-history', 'UserController@ordersHistory');

  Route::get('update-password', 'UserController@getUpdatePassword');

  Route::post('update-password', 'UserController@postUpdatePassword');

});

Route::middleware(['checkAuthorization']) -> prefix('inventory') -> group(function () {

  Route::get('product', 'Inventory\ProductController@getProducts');

  Route::post('product', 'Inventory\ProductController@postProducts');

  Route::get('product/new-product', 'Inventory\ProductController@getAddNewProduct');

  Route::post('product/new-product', 'Inventory\ProductController@postAddNewProduct');

  Route::get('product/{id}', 'Inventory\ProductController@getProduct');

  Route::post('product/{id}', 'Inventory\ProductController@postProduct');

});

Route::middleware(['checkAuthorization']) -> prefix('shop')->group(function () {

  Route::get('search', 'Shop\SearchController@handle');

  Route::get('category', 'Shop\CategoryController@getCategories');

  Route::get('category/{id}', 'Shop\CategoryController@getCategory');

  Route::get('product', 'Shop\ProductController@getProducts');

  Route::get('product/{id}', 'Shop\ProductController@getProduct');

  Route::post('product/{id}/addToCart', 'Shop\ProductController@addToCart');

  Route::post('product/{id}/removeFromCart', 'Shop\ProductController@removeFromCart');

  Route::post('product/{id}/setCartQuantity', 'Shop\ProductController@setCartQuantity');

  Route::post('product/{id}/increaseCartQuantity', 'Shop\ProductController@increaseCartQuantity');

  Route::post('product/{id}/decreaseCartQuantity', 'Shop\ProductController@decreaseCartQuantity');

  Route::post('product/{id}/setRating', 'Shop\ProductController@setRating');

});

Route::middleware(['checkAuthorization']) -> prefix('checkout')->group(function () {

  Route::get('cart', 'Shop\CheckoutController@cart');

  Route::get('checkout', 'Shop\CheckoutController@getCheckout');

  Route::post('checkout', 'Shop\CheckoutController@postCheckout');

  Route::get('thank-you', 'Shop\CheckoutController@thankYou');

});
