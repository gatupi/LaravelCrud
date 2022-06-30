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

use Illuminate\Http\Request;

Route::resource('customer', 'CustomerController'); // gera todas as rotas necessárias para os métodos na controller gerados com o parâmetro --resource
Route::resource('product', 'ProductController');
Route::resource('brand', 'BrandController');
Route::resource('product-category', 'ProductCategoryController');