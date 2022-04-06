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

Route::match(['GET', 'POST'], '/register', 'AuthController@register');

Route::match(['GET', 'POST'], '/login', 'AuthController@login');

Route::get('/logout', 'AuthController@logout') -> middleware('guest');

Route::match(['GET', 'POST'], '/user/profile', 'UserController@profile') -> middleware('guest');

Route::get('/user/orders-history', 'UserController@ordersHistory') -> middleware('guest');

Route::match(['GET', 'POST'], '/user/update-password', 'UserController@updatePassword') -> middleware('guest');

Route::match(['GET', 'POST'], '/inventory/product', 'Inventory\ProductController@products') -> middleware('guest');

Route::match(['GET', 'POST'], '/inventory/product/add-new-product', 'Inventory\ProductController@addNewProduct') -> middleware('guest');

Route::match(['GET', 'POST'], '/inventory/product/{id}', 'Inventory\ProductController@product') -> middleware('guest');

Route::get('/shop/search', 'Shop\SearchController@handle') -> middleware('guest');

Route::match(['GET', 'POST'], '/shop/category', 'Shop\CategoryController@categories') -> middleware('guest');

Route::match(['GET', 'POST'], '/shop/category/{id}', 'Shop\CategoryController@category') -> middleware('guest');

Route::match(['GET', 'POST'], '/shop/product', 'Shop\ProductController@products') -> middleware('guest');

Route::match(['GET', 'POST'], '/shop/product/{id}', 'Shop\ProductController@product') -> middleware('guest');

Route::post('/shop/product/{id}/addToCart', 'Shop\ProductController@addToCart') -> middleware('guest');

Route::post('/shop/product/{id}/removeFromCart', 'Shop\ProductController@removeFromCart') -> middleware('guest');

Route::post('/shop/product/{id}/setCartQuantity', 'Shop\ProductController@setCartQuantity') -> middleware('guest');

Route::post('/shop/product/{id}/increaseCartQuantity', 'Shop\ProductController@increaseCartQuantity') -> middleware('guest');

Route::post('/shop/product/{id}/decreaseCartQuantity', 'Shop\ProductController@decreaseCartQuantity') -> middleware('guest');

Route::post('/shop/product/{id}/setRating', 'Shop\ProductController@setRating') -> middleware('guest');

Route::get('/checkout/cart', 'Shop\CheckoutController@cart') -> middleware('guest');

Route::match(['GET', 'POST'], '/checkout/checkout', 'Shop\CheckoutController@checkout') -> middleware('guest');

Route::get('/checkout/thank-you', 'Shop\CheckoutController@thankYou') -> middleware('guest');
