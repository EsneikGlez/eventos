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

use App\Package;
Route::get('/', function () {
    return view('welcome')->with([
        'packages'=>Package::paginate()
    ]);
})->name('welcome');
# nombre / accion / parametro requerido
Route::get('events/confirm/{event}', 'EventController@confirm')->name('events.confirm');
Route::put('events/photos/{event}', 'EventController@photos')->name('events.photos');
Route::resource('events', 'EventController');
Route::get('packages/activar/{package}', 'PackageController@toggle')->name('packages.toggle');
Route::resource('packages', 'PackageController')->except(['destroy']);
Route::resource('photos', 'PhotoController');
Route::get('payments/index', 'PaymentController@index')->name('payments.index');
Route::get('payments/create/{event}','PaymentController@create')->name('payments.create');
Route::post('payments/store/{event}','PaymentController@store')->name('payments.store');
Route::put('users/password/{user}', 'UserController@password')->name('users.password');
Route::resource('users', 'UserController');
Route::resource('expenses', 'ExpenseController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
