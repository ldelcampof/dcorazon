<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('catalog/categories',['uses' => 'CategoriesController@all' ]);
Route::resource('category', 'CategoriesController', ['only' => [
	'index',
	'store',
	'destroy',
]]);
Route::resource('product', 'ProductsController', ['only' => [
	'index',
	'store',
	'update',
	'destroy',
	'show'
]]);
Route::resource('sale', 'SalesController', ['only' => [
	'index',
	'store',
	'update',
	'destroy',
	'show'
]]);
Route::post('update/product/{product_id}', ['uses' => 'ProductsController@store']);
Route::get('search/product', ['uses' => 'ProductsController@search']);