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
     Route::post('login', 'AuthController@login');
//     Route::post('register', 'AuthController@register');


    Route::get('categories/random/{count}', 'CategoryController@random');
    Route::get('products/top/{count}', 'ProductController@top');
    Route::get('categories', 'CategoryController@indexApi'); // ini
    Route::get('products', 'ProductController@indexApi'); // <= ini ya
    Route::get('categories/slug/{slug}', 'CategoryController@slug'); 
    Route::get('products/search/{keyword}', 'ProductController@search');
    Route::post('products/cart', 'ProductController@cart'); 
    Route::get('products/slug/{slug}', 'ProductController@slug');

    Route::get('provinces', 'ShopController@provinces');
    //Route::get('provinces', 'ShopController@provinces');
    Route::get('cities', 'ShopController@cities');
    Route::get('couriers', 'ShopController@couriers');
//     Route::middleware('auth:api')->get('/user', function (Request $request) {
//         Route::post('logout', 'AuthController@logout');
//         Route::post('shipping', 'ShopController@shipping');
//         Route::post('services', 'ShopController@services');
//         Route::post('payment', 'ShopController@payment');
//         Route::get('my-order', 'ShopController@myOrder');
//     return $request->user();
// });
Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', 'AuthController@logout');
    Route::post('shipping', 'ShopController@shipping');
    Route::post('services', 'ShopController@services');
    Route::post('payment', 'ShopController@payment');
    Route::get('my-order', 'ShopController@myOrder');
    //...
}); 

});