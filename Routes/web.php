<?php

use App\Http\Services\Route; 

/*
 * Uer authentication//
 */
Route::get('/login', '\Auth@login');
Route::get('/register', 'UserController@create');
Route::post('/register', 'UserController@store');
Route::get('/forgot/password', 'Auth@forgotPassword');
Route::post('/forgot/password', 'Auth@forgotPasswordSendEmail');

Route::post('/login', '\Auth@userAuth');
Route::get('/logOut', '\Auth@logOut');
/*
 * Uer authentication end//
 */


Route::get('/user/list', 'UserController@index');
Route::get('/change/password', 'UserController@changePassword');
Route::post('/user/password/update/{id}', 'UserController@passwordUpdate');
/*
 */

Route::get('/', function () {
    return view('backend.dashboard');
})->middleware(['Authentication:admin']);
Route::get('/dashboard', function () {
    return view('backend.dashboard');
})->middleware(['Authentication:admin']);


// Product manage
Route::get('/product/items', 'shop\ShoppingController@products');
Route::get('/products', 'shop\ShoppingController@shopping');
Route::get('/product/delete/{id}', 'shop\ShoppingController@destroy');
Route::post('/product/store', 'shop\ShoppingController@store');
Route::post('/product/edit/{id}', 'shop\ShoppingController@update');

// product Category manage
Route::get('/category/all', 'shop\CategoryController@categories');
Route::get('/product/categories', 'shop\CategoryController@index');
Route::post('/category/store', 'shop\CategoryController@store');
Route::post('/category/edit/{id}', 'shop\CategoryController@update');
Route::get('/category/delete/{id}', 'shop\CategoryController@delete');
