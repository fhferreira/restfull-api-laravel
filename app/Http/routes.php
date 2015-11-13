<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource("category", "CategoryController", ['only' => ['index', 'show']]);
Route::post('category/create', ['uses' => 'CategoryController@create','middleware'=>'auth.basic.once']);

Route::group(['prefix' => 'api/v1'], function() {
	Route::resource("product", "ProductController", ['except' => ['create', 'store', 'update', 'destroy', 'show']]);
	Route::get("product/{id}", ['uses' => 'ProductController@show', 'middleware'=>'auth.basic.once']);
	Route::post('product/create', ['uses' => 'ProductController@create','middleware'=>'auth.basic.once']);
});