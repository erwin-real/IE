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

Route::get('/', function () { return view('welcome'); });
Route::get('/dashboard', 'DashboardController@index');

Route::get('/reports', 'ReportsController@index');
Route::get('/reports/forecast', 'ReportsController@forecast');
Route::post('/reports/forecast', 'ReportsController@calculate');

// Guides
Route::get('/guide/products', 'GuideController@products');
Route::get('/guide/transactions', 'GuideController@transactions');
Route::get('/guide/users', 'GuideController@users');

//Auth::routes();

// Reset Password
Route::get('/resetPassword/{id}','DashboardController@showResetPasswordForm');
Route::post('/resetPassword','DashboardController@resetPassword')->name('resetPassword');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Users
Route::get('/users/create', 'DashboardController@addUser');
Route::get('/users/{id}', 'DashboardController@showUser');
Route::post('/users','DashboardController@saveUser');
Route::get('/users','DashboardController@users');
Route::get('/users/{id}/edit','DashboardController@editUser');
Route::delete('/users/{id}','DashboardController@destroyUser');
Route::put('/users/{id}','DashboardController@updateUser');

Route::get('/products/action', 'ProductsController@action')->name('products.action');
Route::get('/products/transact', 'ProductsController@transact')->name('products.transact');
Route::get('/products/import', 'ProductsController@import');
Route::post('/products/uploadFile', 'ProductsController@uploadCSVFile');
Route::get('/products/search', 'ProductsController@search');

Route::get('/transactions/get', 'TransactionsController@get')->name('transactions.get');
Route::get('/transactions/success', 'TransactionsController@success');
Route::get('/transactions/export/{id}', 'TransactionsController@export');

Route::resource('products', 'ProductsController');

Route::resource('transactions', 'TransactionsController')->except([
    'edit', 'update'
]);