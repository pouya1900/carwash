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

Route::get('/', 'Home\HomeController@index')->name("home");
Route::get('/cronjob/notification/one_hour', 'Cronjob\ReservationController@send_notification_before_one_hour')->name("send_notification_before_one_hour");


Route::group(['prefix' => 'payment', "namespace" => "Payment"], function () {

    Route::get('balance/verify/{payment}', 'PaymentController@verifyBalance')->name("verifyPayment");
    Route::get('reserve/verify/{payment}', 'PaymentController@verifyReserve')->name("reserveVerifyPayment");

});


Route::get('/payment/reserve/success')->name("deep_link_success");
Route::get('/payment/reserve/failed')->name("deep_link_failed");
