<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//
//Route::get('/', function () {
//    return view('dashboard');
//});
Route::get( '/', "DashboardController@index" );
Route::get( '/customers', 'CustomersController@index' );
Route::get( '/customers/new', 'CustomersController@edit' );
Route::post('/customers/new','CustomersController@store');

Route::get( '/customers/edit/{id}', 'CustomersController@edit' );
Route::post('/customers/edit/{id}','CustomersController@store');


Route::get( '/orders', 'OrdersController@index' );
Route::get( '/orders/new', 'OrdersController@edit' );
Route::post('/orders/new','OrdersController@store');
Route::get( '/orders/view/{id}', 'OrdersController@view' );

//Route::match( [ 'get', 'post' ],
//              '/customers/new',
//              'CustomersController@newOrEdit' );
//Route::match( [ 'get', 'post' ],
//              '/customers/edit/{id}',
//              'CustomersController@newOrEdit' );