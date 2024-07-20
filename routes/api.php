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
    Route::get('types', 'CarPropertyController@types');
    Route::get('brands', 'CarPropertyController@brands');
    Route::get('models', 'CarPropertyController@models');
    Route::get('colors', 'CarPropertyController@colors');
    Route::get('car-property', 'CarPropertyController@carProperty');
    Route::get('states', 'PlaceController@states');
    Route::get('cancellation-rules/{reservation}', 'CancellationController@rules');
});

Route::group(['prefix' => 'carwashes', "namespace" => "Reservation", 'middleware' => "optionalJwtAuth"], function () {
    Route::get('/', 'CarwashController@index');
    Route::get('/times_list', 'CarwashController@times_list');
    Route::get('/show/{carwash}', 'CarwashController@show');
    Route::get('services/{carwash}', 'CarwashController@services');
    Route::get('products', 'CarwashController@products');
    Route::get('times/{carwash}', 'CarwashController@times');

    Route::get('products/show/{product}', 'CarwashController@product_show');
    Route::get('services/show/{service}', 'CarwashController@service_show');

    Route::get('products/categories', 'CarwashController@categories');

    Route::get('products/scores/{product}', 'CarwashController@product_scores');
    Route::get('scores/{carwash}', 'CarwashController@carwash_scores');

    Route::get('base_services', 'CarwashController@base_services');
    Route::get('base_items', 'CarwashController@base_items');

});

Route::group(['prefix' => 'auth', "namespace" => "Auth"], function () {

    Route::post('send-otp', 'AuthController@send_otp');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');

});
Route::group(['prefix' => 'home', "namespace" => "Home", 'middleware' => "optionalJwtAuth"], function () {
    Route::get('/', 'HomeController@index');
});

Route::group(['prefix' => 'user', 'middleware' => "jwtAuth", "namespace" => "User"], function () {
    Route::get('/', 'UsersController@show');
    Route::post('/update', 'UsersController@update');
    Route::get('/balance/increase', 'UsersController@increaseBalance');
    Route::get('/payment/verify/{payment}', 'UsersController@verifyPayment')->name("verifyPayment");
    Route::get('/inactive', 'UsersController@inactive');

    Route::post('/update-location', 'UsersController@update_location');


    Route::post('firebase/update', 'UsersController@firebaseUpdate');

    Route::get('/gifts/receive/{gift}', 'UsersController@receive_gift');

    Route::get('/addresses', 'AddressController@index');
    Route::post('/addresses/store', 'AddressController@store');
    Route::post('/addresses/update/{address}', 'AddressController@update');
    Route::get('/addresses/delete/{address}', 'AddressController@delete');

    Route::get('/cars', 'CarController@index');
    Route::post('/cars/store', 'CarController@store');
    Route::post('/cars/update/{car}', 'CarController@update');
    Route::get('/cars/delete/{car}', 'CarController@delete');
    Route::get('/cars/clear', 'CarController@clearDefault');
    Route::get('/cars/default/{car}', 'CarController@makeDefault');

    Route::get('/like/product/{product}', 'ActionController@like_product');
    Route::get('/like/carwash/{carwash}', 'ActionController@like_carwash');
    Route::get('/bookmark/product/{product}', 'ActionController@bookmark_product');
    Route::get('/bookmark/carwash/{carwash}', 'ActionController@bookmark_carwash');

    Route::get('/tickets', 'TicketController@index');
    Route::get('/tickets/show/{ticket}', 'TicketController@show');
    Route::post('/tickets/store', 'TicketController@store');
    Route::post('/tickets/update/{ticket}', 'TicketController@update');

    Route::get('/reservations', 'ReservationController@index');
    Route::post('/reserve', 'ReservationController@reserve');
    Route::get('/reservation/cancel/{reservation}', 'ReservationController@cancel');
    Route::post('/reservation/score/{reservation}', 'ReservationController@score');

    Route::get('/reservation/update/{reservation}', 'ReservationController@update');


    Route::get('/deposits', 'DepositController@index');
    Route::post('/deposits/store', 'DepositController@store');

    Route::get('/banks', 'BankController@index');
    Route::post('/banks/store', 'BankController@store');

});


Route::group(['prefix' => 'carwash', 'middleware' => "jwtCarwashAuth", "namespace" => "Carwash"], function () {
    Route::get('/', 'CarwashController@show');
    Route::post('/update', 'CarwashController@update');

    Route::get('/reservations', 'ReservationController@reservations');

    Route::post('/schedule', 'TimeController@schedule');
    Route::get('/times', 'TimeController@index');
    Route::post('/times/update', 'TimeController@update');
    Route::get('/times/delete/{time}', 'TimeController@delete');

    Route::post('/message', 'CarwashController@message');

    Route::get('/discounts', 'DiscountController@index');
    Route::post('/discounts/store', 'DiscountController@store');
    Route::get('/discounts/delete/{discount}', 'DiscountController@delete');

    Route::get('/services', 'ServiceController@index');
    Route::post('/services/store', 'ServiceController@store');
    Route::post('/services/update/{service}', 'ServiceController@update');
    Route::get('/services/delete/{service}', 'ServiceController@delete');

    Route::get('/products', 'ProductController@index');
    Route::post('/products/store', 'ProductController@store');
    Route::post('/products/update/{product}', 'ProductController@update');
    Route::get('/products/delete/{product}', 'ProductController@delete');


});



