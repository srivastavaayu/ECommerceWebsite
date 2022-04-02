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

Route::get('/logout', 'Auth\LogoutController@handle');

Route::match(['GET', 'POST'], '/register', 'Auth\RegisterController@handle');

Route::match(['GET', 'POST'], '/login', 'Auth\LoginController@handle');

Route::match(['GET', 'POST'], '/user/profile', 'UserController@profile');

Route::get('/user/orders-history', 'UserController@ordersHistory');

Route::match(['GET', 'POST'], '/user/update-password', 'UserController@updatePassword');

Route::match(['GET', 'POST'], '/inventory/product', 'Inventory\ProductsController@handle');

Route::match(['GET', 'POST'], '/inventory/product/add-new-product', 'Inventory\AddNewProductController@handle');

Route::match(['GET', 'POST'], '/inventory/product/{id}', 'Inventory\ProductController@handle');

Route::get('/shop/search', 'Shop\SearchController@handle');

Route::match(['GET', 'POST'], '/shop/category', 'Shop\CategoriesController@handle');

Route::match(['GET', 'POST'], '/shop/category/{id}', 'Shop\CategoryController@handle');

Route::match(['GET', 'POST'], '/shop/product', 'Shop\ProductsController@handle');

Route::match(['GET', 'POST'], '/shop/product/{id}', 'Shop\ProductController@handle');

Route::post('/shop/product/{id}/addToCart', 'Shop\ProductController@addToCart');

Route::post('/shop/product/{id}/removeFromCart', 'Shop\ProductController@removeFromCart');

Route::post('/shop/product/{id}/increaseCartQuantity', 'Shop\ProductController@increaseCartQuantity');

Route::post('/shop/product/{id}/decreaseCartQuantity', 'Shop\ProductController@decreaseCartQuantity');

Route::get('/checkout/cart', 'Shop\CheckoutController@getCart');

Route::match(['GET', 'POST'], '/checkout/checkout', 'Shop\CheckoutController@getCheckout');

Route::get('/checkout/thank-you', 'Shop\CheckoutController@getThankYou');
