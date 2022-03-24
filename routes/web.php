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

Route::match(['GET', 'POST'], '/user/profile', 'User\ProfileController@handle');

Route::match(['GET', 'POST'], '/user/update-password', 'User\UpdatePasswordController@handle');

Route::get('/shop/search', 'Shop\SearchController@handle');
