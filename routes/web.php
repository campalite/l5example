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
    return view('home');
});

Route::get('contact', 'ContactFormController@create')->name('contact.create');
Route::post('contact', 'ContactFormController@store')->name('contact.store');
//Route::view('contact','contact');
Route::view('about','about')->middleware('test');

Route::get('customers', 'CustomersController@index');
Route::get('customers/create', 'CustomersController@create');
Route::post('customers','CustomersController@store');
Route::get('customers/{customer}','CustomersController@show')->middleware('can:view, customer');
Route::get('customers/{customer}/edit','CustomersController@edit');
Route::post('customers/{customer}','CustomersController@update');
Route::delete('customers/{customer}','CustomersController@destroy');


// create middleware option1
//Route::resource('customers','CustomersController')->middleware('auth');
Route::resource('customers','CustomersController');
Auth::routes();

Route::get('/home', 'HomeController@index');
