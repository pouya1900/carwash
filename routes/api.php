<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['prefix' => 'other', "namespace" => "Other"], function () {
    Route::post('upload', 'MediaController@storeImage');
});

Route::group(['prefix' => 'other', "namespace" => "Other"], function () {
    Route::post('upload', 'MediaController@storeImage');
    Route::get('types', 'CarPropertyController@types');
    Route::get('brands', 'CarPropertyController@brands');
    Route::get('models', 'CarPropertyController@models');
    Route::get('colors', 'CarPropertyController@colors');
});

Route::group(['prefix' => 'carwashes', "namespace" => "Reservation"], function () {
    Route::get('/', 'CarwashController@index');
    Route::get('/show/{carwash}', 'CarwashController@show');
    Route::get('services/{carwash}', 'CarwashController@services');
    Route::get('products', 'CarwashController@products');
});

Route::group(['prefix' => 'auth', "namespace" => "Auth"], function () {

    Route::post('send-otp', 'AuthController@send_otp');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');

});
Route::group(['prefix' => 'home', "namespace" => "Home"], function () {
    Route::get('/', 'HomeController@index');
});

Route::group(['prefix' => 'user', 'middleware' => "jwtAuth", "namespace" => "User"], function () {
    Route::get('/', 'UsersController@show');
    Route::post('/update', 'UsersController@update');
    Route::get('/balance/increase', 'UsersController@increaseBalance');

    Route::get('/reservations', 'ReservationController@reservations');

    Route::get('/addresses', 'AddressController@index');
    Route::post('/addresses/store', 'AddressController@store');
    Route::post('/addresses/update/{address}', 'AddressController@update');
    Route::get('/addresses/delete/{address}', 'AddressController@delete');

    Route::get('/cars', 'CarController@index');
    Route::post('/cars/store', 'CarController@store');
    Route::post('/cars/update/{car}', 'CarController@update');
    Route::get('/cars/delete/{car}', 'CarController@delete');

});


Route::group(['prefix' => 'carwash', 'middleware' => "jwtCarwashAuth", "namespace" => "Carwash"], function () {
    Route::get('/', 'CarwashController@show');
    Route::post('/update', 'CarwashController@update');

    Route::get('/reservations', 'ReservationController@reservations');

    Route::get('/services', 'ServiceController@index');
    Route::post('/services/store', 'ServiceController@store');
    Route::post('/services/update/{service}', 'ServiceController@update');
    Route::get('/services/delete/{service}', 'ServiceController@delete');

    Route::get('/products', 'productController@index');
    Route::post('/products/store', 'productController@store');
    Route::post('/products/update/{product}', 'productController@update');
    Route::get('/products/delete/{product}', 'productController@delete');


});



