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


Route::get('/login/{type}', 'AuthController@login')->name('login');
Route::post('/otp', 'AuthController@send_otp')->name('send_otp');
Route::post('/doLogin/carwash', 'AuthController@do_carwash_login')->name('do_login_carwash');
Route::post('/doLogin/user', 'AuthController@do_user_login')->name('do_login_user');
Route::post('/doLogin/admin', 'AuthController@do_admin_login')->name('do_login_admin');
Route::get('/logout', 'AuthController@logout')->name('logout');


Route::group(['prefix' => 'payment', "namespace" => "Payment"], function () {

    Route::get('balance/verify/{payment}', 'PaymentController@verifyBalance')->name("verifyPayment");
    Route::get('reserve/verify/{payment}', 'PaymentController@verifyReserve')->name("reserveVerifyPayment");

});


Route::get('/payment/reserve/success')->name("deep_link_success");
Route::get('/payment/reserve/failed')->name("deep_link_failed");


Route::group(['middleware' => ['carwash.auth'], 'prefix' => '/carwash', 'namespace' => 'Carwash'], function () {
    Route::get('/dashboard', 'CarwashController@dashboard')->name('carwash_dashboard');

    Route::get('/notifications', 'CarwashController@notifications')->name('carwash_notifications');


    Route::get('/profile/edit', 'CarwashController@edit')->name('carwash_edit');
    Route::post('/profile/update', 'CarwashController@update')->name('carwash_update');

    Route::get('/tickets', 'TicketController@index')->name('carwash_tickets');
    Route::get('/tickets/create', 'TicketController@create')->name('carwash_ticket_create');
    Route::post('/tickets/store', 'TicketController@store')->name('carwash_ticket_store');
    Route::get('/tickets/edit/{ticket}', 'TicketController@edit')->name('carwash_ticket_edit');
    Route::post('/tickets/update/{ticket}', 'TicketController@update')->name('carwash_ticket_update');

    Route::get('/services', 'ServiceController@services')->name('carwash_services');
    Route::get('/services/create', 'ServiceController@create')->name('carwash_service_create');
    Route::post('/services/store', 'ServiceController@store')->name('carwash_service_store');
    Route::get('/services/edit/{service}', 'ServiceController@edit')->name('carwash_service_edit');
    Route::post('/services/update/{service}', 'ServiceController@update')->name('carwash_service_update');
    Route::get('/services/delete/{service}', 'ServiceController@remove')->name('carwash_service_delete');

    Route::get('/reservations', 'ReservationController@index')->name('carwash_reservations');
    Route::get('/reservations/show/{reservation}', 'ReservationController@show')->name('carwash_reservation_show');


    Route::get('/blogs', 'BlogController@index')->name('carwash_blogs');
    Route::get('/blogs/create', 'BlogController@create')->name('carwash_blog_create');
    Route::post('/blogs/store', 'BlogController@store')->name('carwash_blog_store');
    Route::get('/blogs/edit/{blog}', 'BlogController@edit')->name('carwash_blog_edit');
    Route::post('/blogs/update/{blog}', 'BlogController@update')->name('carwash_blog_update');
    Route::get('/blogs/delete/{blog}', 'BlogController@delete')->name('carwash_blog_delete');

    Route::get('/banks', 'BankController@index')->name('carwash_banks');
    Route::get('/banks/create', 'BankController@create')->name('carwash_bank_create');
    Route::post('/banks/store', 'BankController@store')->name('carwash_bank_store');
    Route::get('/banks/edit/{bank}', 'BankController@edit')->name('carwash_bank_edit');
    Route::post('/banks/update/{bank}', 'BankController@update')->name('carwash_bank_update');
    Route::get('/banks/delete/{bank}', 'BankController@delete')->name('carwash_bank_delete');

    Route::get('/times', 'TimeController@index')->name('carwash_times');
    Route::post('/times/update', 'TimeController@update')->name('carwash_time_update');
    Route::get('/times/remove/{time}', 'TimeController@remove')->name('carwash_time_remove');

    Route::get('/timetable', 'TimeController@timetable')->name('carwash_timetable');
    Route::post('/timetable/update', 'TimeController@timetableUpdate')->name('carwash_timetable_update');

    Route::get('/payments/incomes', 'PaymentController@incomes')->name('carwash_incomes');
    Route::get('/payments/withdraws', 'PaymentController@withdraws')->name('carwash_withdraws');
    Route::get('/payments/withdraws/create', 'PaymentController@create')->name('carwash_withdraw_create');
    Route::post('/payments/withdraws/store', 'PaymentController@store')->name('carwash_withdraw_store');
    Route::get('/payments/withdraws/delete/{deposit}', 'PaymentController@delete')->name('carwash_withdraw_delete');

    Route::get('/products', 'ProductController@index')->name('carwash_products');
    Route::get('/products/create', 'ProductController@create')->name('carwash_product_create');
    Route::post('/products/store', 'ProductController@store')->name('carwash_product_store');
    Route::get('/products/edit/{product}', 'ProductController@edit')->name('carwash_product_edit');
    Route::post('/products/update/{product}', 'ProductController@update')->name('carwash_product_update');
    Route::get('/products/delete/{product}', 'ProductController@delete')->name('carwash_product_delete');
    Route::get('/products/images/{product}', 'ProductController@images')->name('carwash_product_images');

});
