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
Route::prefix('v1')->group(function () { 
//     // public
//     Route::post('login', 'AuthController@login');
//     Route::post('register', 'AuthController@register');

    Route::get('categories/random/{count}', 'CategoryController@random'); // <== ini ya gaes
    Route::get('products/top/{count}', 'ProductController@top'); // <= ini ya
    Route::get('categories', 'CategoryController@indexApi'); // ini
    Route::get('products', 'ProductController@indexApi'); // <= ini ya
    Route::get('categories/slug/{slug}', 'CategoryController@slug'); 
    Route::get('products/search/{keyword}', 'ProductController@search'); 
    Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
});