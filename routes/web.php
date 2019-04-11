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

Route::get('/', 'WelcomeController@showWelcomePage')->name('welcome');

Route::get('categories/{title}-{id}/products', 'CategoryProductController@showProducts')->name('categories.products.show');

Route::get('products/{title}-{id}', 'ProductController@showProduct')->name('products.show');

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', 'HomeController@index')->name('home');
