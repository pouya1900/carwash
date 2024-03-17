<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'HomeController@index')->name("home");


Route::group(['prefix' => 'payment', "namespace" => "Payment"], function () {

    Route::get('balance/verify/{payment}', 'PaymentController@verifyBalance')->name("verifyPayment");
    Route::get('reserve/verify/{payment}', 'PaymentController@verifyReserve')->name("reserveVerifyPayment");

});


Route::get('/payment/reserve/success')->name("deep_link");
