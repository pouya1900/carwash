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



Route::group(['middleware' => ['carwash.auth'], 'prefix' => '/servant', 'namespace' => 'App\Http\Controllers\Servant'], function () {
    Route::get('/dashboard', 'ServantController@dashboard')->name('servant_dashboard');

    Route::get('/notifications', 'ServantController@notifications')->name('servant_notifications');


    Route::get('/profile/edit', 'ServantController@edit')->name('servant_edit');
    Route::post('/profile/update', 'ServantController@update')->name('servant_update');
    Route::get('/content/create', 'ServantController@create_content')->name('servant_create_content');
    Route::post('/content/store', 'ServantController@store_content')->name('servant_store_content');
    Route::post('/profile/about/update', 'ServantController@about_update')->name('servant_about_update');
    Route::post('/profile/slideshow/update', 'ServantController@slideshow_update')->name('servant_slideshow_update');

    Route::get('/tickets', 'TicketController@index')->name('servant_tickets');
    Route::get('/tickets/create', 'TicketController@create')->name('servant_ticket_create');
    Route::post('/tickets/store', 'TicketController@store')->name('servant_ticket_store');
    Route::get('/tickets/edit/{ticket}', 'TicketController@edit')->name('servant_ticket_edit');
    Route::post('/tickets/update/{ticket}', 'TicketController@update')->name('servant_ticket_update');

    Route::get('/services', 'ServiceController@services')->name('servant_services');
    Route::get('/services/create', 'ServiceController@create')->name('servant_service_create');
    Route::post('/services/store', 'ServiceController@store')->name('servant_service_store');
    Route::get('/services/edit/{service}', 'ServiceController@edit')->name('servant_service_edit');
    Route::post('/services/update/{service}', 'ServiceController@update')->name('servant_service_update');
    Route::get('/services/delete/{service}', 'ServiceController@remove')->name('servant_service_delete');

    Route::get('/reservations', 'ReservationController@index')->name('servant_reservations');
    Route::get('/reservations/show/{reservation}', 'ReservationController@show')->name('servant_reservation_show');
    Route::get('/reservations/messages/{reservation}/index', 'ReservationController@get_messages')->name('servant_reservation_messages');
    Route::post('/reservations/messages/{reservation}/new', 'ReservationController@new_message')->name('servant_reservation_new_message');
    Route::post('/reservations/guarantee/update/{reservation}', 'ReservationController@store_guarantee')->name('servant_reservation_update_guarantee');
    Route::get('/reservations/guarantee/delete/{guarantee}', 'ReservationController@delete_guarantee')->name('servant_reservation_delete_guarantee');
    Route::post('/reservations/video/{reservation}', 'ReservationController@video_chat')->name('servant_reservation_video_chat');
    Route::get('/reservations/update/{reservation}/{status}', 'ReservationController@update_status')->name('servant_reservation_update_status');
    Route::post('/reservations/record/store/{reservation}', 'ReservationController@store_record')->name('servant_reservation_store_record');
    Route::get('/reservations/record/delete/{record}', 'ReservationController@delete_record')->name('servant_reservation_delete_record');


    Route::get('/blogs', 'BlogController@index')->name('servant_blogs');
    Route::get('/blogs/create', 'BlogController@create')->name('servant_blog_create');
    Route::post('/blogs/store', 'BlogController@store')->name('servant_blog_store');
    Route::get('/blogs/edit/{blog}', 'BlogController@edit')->name('servant_blog_edit');
    Route::post('/blogs/update/{blog}', 'BlogController@update')->name('servant_blog_update');
    Route::get('/blogs/delete/{blog}', 'BlogController@delete')->name('servant_blog_delete');

    Route::get('/banks', 'BankController@index')->name('servant_banks');
    Route::get('/banks/create', 'BankController@create')->name('servant_bank_create');
    Route::post('/banks/store', 'BankController@store')->name('servant_bank_store');
    Route::get('/banks/edit/{bank}', 'BankController@edit')->name('servant_bank_edit');
    Route::post('/banks/update/{bank}', 'BankController@update')->name('servant_bank_update');
    Route::get('/banks/delete/{bank}', 'BankController@delete')->name('servant_bank_delete');

    Route::get('/times', 'TimeController@index')->name('servant_times');
    Route::post('/times/update', 'TimeController@update')->name('servant_time_update');
    Route::get('/times/remove/{time}', 'TimeController@remove')->name('servant_time_remove');

    Route::get('/timetable', 'TimeController@timetable')->name('servant_timetable');
    Route::post('/timetable/update', 'TimeController@timetableUpdate')->name('servant_timetable_update');


    Route::get('/payments/incomes', 'PaymentController@incomes')->name('servant_incomes');
    Route::get('/payments/withdraws', 'PaymentController@withdraws')->name('servant_withdraws');
    Route::get('/payments/withdraws/create', 'PaymentController@create')->name('servant_withdraw_create');
    Route::post('/payments/withdraws/store', 'PaymentController@store')->name('servant_withdraw_store');
    Route::get('/payments/withdraws/delete/{deposit}', 'PaymentController@delete')->name('servant_withdraw_delete');

    Route::get('/products', 'ProductController@index')->name('servant_products');
    Route::get('/products/create', 'ProductController@create')->name('servant_product_create');
    Route::post('/products/store', 'ProductController@store')->name('servant_product_store');
    Route::get('/products/edit/{product}', 'ProductController@edit')->name('servant_product_edit');
    Route::post('/products/update/{product}', 'ProductController@update')->name('servant_product_update');
    Route::get('/products/delete/{product}', 'ProductController@delete')->name('servant_product_delete');
    Route::get('/products/images/{product}', 'ProductController@images')->name('servant_product_images');

    Route::get('/subs', 'SubController@index')->name('servant_subs');
    Route::get('/subs/requested', 'SubController@requested')->name('servant_requested_subs');
    Route::get('/subs/create', 'SubController@create')->name('servant_sub_create');
    Route::post('/subs/store', 'SubController@store')->name('servant_sub_store');
    Route::get('/subs/delete/{o_servant}', 'SubController@delete')->name('servant_sub_delete');
    Route::get('/subs/accept/{o_servant}', 'SubController@accept')->name('servant_sub_accept');

    Route::get('/parents', 'ParentController@index')->name('servant_parents');
    Route::get('/parents/requested', 'ParentController@requested')->name('servant_requested_parents');
    Route::get('/parents/create', 'ParentController@create')->name('servant_parent_create');
    Route::post('/parents/store', 'ParentController@store')->name('servant_parent_store');
    Route::get('/parents/delete/{o_servant}', 'ParentController@delete')->name('servant_parent_delete');
    Route::get('/parents/accept/{o_servant}', 'ParentController@accept')->name('servant_parent_accept');

    Route::get('/addresses', 'AddressController@index')->name('servant_addresses');
    Route::get('/addresses/create', 'AddressController@create')->name('servant_address_create');
    Route::post('/addresses/store', 'AddressController@store')->name('servant_address_store');
    Route::get('/addresses/edit/{address}', 'AddressController@edit')->name('servant_address_edit');
    Route::post('/addresses/update/{address}', 'AddressController@update')->name('servant_address_update');
    Route::get('/addresses/delete/{address}', 'AddressController@delete')->name('servant_address_delete');


});
