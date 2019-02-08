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
    return view('auth.login');
});

Auth::routes();

Route::match(["GET", "POST"], "/register", function(){
    return redirect("/login");
})->name("register");


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin','AdminController@index')->name('admin');
Route::get('/categories/{id}/restore', 'CategoryController@restore')->name('categories.restore');
Route::get('/categories/trash', 'CategoryController@trash')->name('categories.trash');
Route::delete('/categories/{id}/delete-permanent', 'CategoryController@deletePermanent')->name('categories.delete-permanent');
Route::get('/ajax/categories/search', 'CategoryController@ajaxSearch');
Route::get('/products/trash', 'ProductController@trash')->name('products.trash');
Route::post('/products/{id}/restore', 'ProductController@restore')->name('products.restore');
Route::delete('/products/{id}/delete-permanent', 'ProductController@deletePermanent')->name('products.delete-permanent');
Route::resource('products', 'ProductController');
Route::resource("users", "UserController");
Route::resource('categories', 'CategoryController');
Route::resource('orders', 'OrderController');