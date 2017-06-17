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


Route::get('aparts', function(){ return view('app.aparts'); });
Route::get('categories', function(){ return view('app.category'); });
Route::get('create-apart', function(){ return view('app.aparts'); });
Route::get('create-sale', function(){ return view('app.createSale'); });
Route::get('products', function(){ return view('app.products'); });
Route::get('sales', function(){ return view('app.sales'); });