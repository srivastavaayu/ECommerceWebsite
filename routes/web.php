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

  // Route::match(['GET', 'POST'], 'profile', 'UserController@profile');

  Route::get('profile', 'UserController@getProfile');

  Route::post('profile', 'UserController@postProfile');

  Route::get('orders-history', 'UserController@ordersHistory');

  // Route::match(['GET', 'POST'], 'update-password', 'UserController@updatePassword');

  Route::get('update-password', 'UserController@getUpdatePassword');

  Route::post('update-password', 'UserController@postUpdatePassword');

});

// Route::match(['GET', 'POST'], '/user/profile', 'UserController@profile') -> middleware('guest');

// Route::get('/user/orders-history', 'UserController@ordersHistory') -> middleware('guest');

// Route::match(['GET', 'POST'], '/user/update-password', 'UserController@updatePassword') -> middleware('guest');

Route::middleware(['checkAuthorization']) -> prefix('inventory') -> group(function () {

  // Route::match(['GET', 'POST'], 'product', 'Inventory\ProductController@products');

  Route::get('product', 'Inventory\ProductController@getProducts');

  Route::post('product', 'Inventory\ProductController@postProducts');

  // Route::match(['GET', 'POST'], 'product/add-new-product', 'Inventory\ProductController@addNewProduct');

  Route::get('product/add-new-product', 'Inventory\ProductController@getAddNewProduct');

  Route::post('product/add-new-product', 'Inventory\ProductController@postAddNewProduct');

  // Route::match(['GET', 'POST'], 'product/{id}', 'Inventory\ProductController@product');

  Route::get('product/{id}', 'Inventory\ProductController@getProduct');

  Route::post('product/{id}', 'Inventory\ProductController@postProduct');

});

// Route::match(['GET', 'POST'], '/inventory/product', 'Inventory\ProductController@products') -> middleware('guest');

// Route::match(['GET', 'POST'], '/inventory/product/add-new-product', 'Inventory\ProductController@addNewProduct') -> middleware('guest');

// Route::match(['GET', 'POST'], '/inventory/product/{id}', 'Inventory\ProductController@product') -> middleware('guest');

Route::middleware(['checkAuthorization']) -> prefix('shop')->group(function () {

  Route::get('search', 'Shop\SearchController@handle');

  // Route::match(['GET', 'POST'], 'category', 'Shop\CategoryController@categories');

  Route::get('category', 'Shop\CategoryController@getCategories');

  // Route::match(['GET', 'POST'], 'category/{id}', 'Shop\CategoryController@category');

  Route::get('category/{id}', 'Shop\CategoryController@getCategory');

  // Route::match(['GET', 'POST'], 'product', 'Shop\ProductController@products');

  Route::get('product', 'Shop\ProductController@getProducts');

  // Route::match(['GET', 'POST'], 'product/{id}', 'Shop\ProductController@product');

  Route::get('product/{id}', 'Shop\ProductController@getProduct');

  Route::post('product/{id}/addToCart', 'Shop\ProductController@addToCart');

  Route::post('product/{id}/removeFromCart', 'Shop\ProductController@removeFromCart');

  Route::post('product/{id}/setCartQuantity', 'Shop\ProductController@setCartQuantity');

  Route::post('product/{id}/increaseCartQuantity', 'Shop\ProductController@increaseCartQuantity');

  Route::post('product/{id}/decreaseCartQuantity', 'Shop\ProductController@decreaseCartQuantity');

  Route::post('product/{id}/setRating', 'Shop\ProductController@setRating');

});

// Route::get('/shop/search', 'Shop\SearchController@handle') -> middleware('guest');

// Route::match(['GET', 'POST'], '/shop/category', 'Shop\CategoryController@categories') -> middleware('guest');

// Route::match(['GET', 'POST'], '/shop/category/{id}', 'Shop\CategoryController@category') -> middleware('guest');

// Route::match(['GET', 'POST'], '/shop/product', 'Shop\ProductController@products') -> middleware('guest');

// Route::match(['GET', 'POST'], '/shop/product/{id}', 'Shop\ProductController@product') -> middleware('guest');

// Route::post('/shop/product/{id}/addToCart', 'Shop\ProductController@addToCart') -> middleware('guest');

// Route::post('/shop/product/{id}/removeFromCart', 'Shop\ProductController@removeFromCart') -> middleware('guest');

// Route::post('/shop/product/{id}/setCartQuantity', 'Shop\ProductController@setCartQuantity') -> middleware('guest');

// Route::post('/shop/product/{id}/increaseCartQuantity', 'Shop\ProductController@increaseCartQuantity') -> middleware('guest');

// Route::post('/shop/product/{id}/decreaseCartQuantity', 'Shop\ProductController@decreaseCartQuantity') -> middleware('guest');

// Route::post('/shop/product/{id}/setRating', 'Shop\ProductController@setRating') -> middleware('guest');

Route::middleware(['checkAuthorization']) -> prefix('checkout')->group(function () {

  Route::get('cart', 'Shop\CheckoutController@cart');

  // Route::match(['GET', 'POST'], 'checkout', 'Shop\CheckoutController@checkout');

  Route::get('checkout', 'Shop\CheckoutController@getCheckout');

  Route::post('checkout', 'Shop\CheckoutController@postCheckout');

  Route::get('thank-you', 'Shop\CheckoutController@thankYou');

});

// Route::get('/checkout/cart', 'Shop\CheckoutController@cart') -> middleware('guest');

// Route::match(['GET', 'POST'], '/checkout/checkout', 'Shop\CheckoutController@checkout') -> middleware('guest');

// Route::get('/checkout/thank-you', 'Shop\CheckoutController@thankYou') -> middleware('guest');
