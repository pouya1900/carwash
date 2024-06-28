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
Route::post('/temp/upload', 'MediaController@tmp')->name('tmp_upload');


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
    Route::get('/reservations/update/{reservation}', 'ReservationController@update')->name('carwash_reservation_update');


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

    Route::get('/users', 'UserController@index')->name('carwash_users');

});


Route::group(['middleware' => ['admin.auth'], 'prefix' => '/admin', 'namespace' => 'Admin'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');

    Route::get('/notifications', 'AdminController@notifications')->name('admin.notifications');

    Route::get('/carwashes', 'CarwashController@index')->name('admin.carwashes')->middleware('admin.permission:carwash.*');
    Route::get('/carwashes/edit/{carwash}', 'CarwashController@edit')->name('admin.carwash.edit')->middleware('admin.permission:carwash.*');
    Route::post('/carwashes/update/{carwash}', 'CarwashController@update')->name('admin.carwash.update')->middleware('admin.permission:carwash.*');
    Route::get('/carwashes/remove/{carwash}', 'CarwashController@remove')->name('admin.carwash.remove')->middleware('admin.permission:carwash.*');

    Route::get('/users', 'UserController@index')->name('admin.users')->middleware('admin.permission:user.*');
    Route::get('/users/edit/{user}', 'UserController@edit')->name('admin.user.edit')->middleware('admin.permission:user.*');
    Route::post('/users/update/{user}', 'UserController@update')->name('admin.user.update')->middleware('admin.permission:user.*');
    Route::get('/users/block/{user}', 'UserController@block')->name('admin.user.block')->middleware('admin.permission:user.*');


    Route::get('/tickets/{type}', 'TicketController@index')->name('admin.tickets')->middleware('admin.permission:ticket.*');
    Route::get('/tickets/edit/{ticket}', 'TicketController@edit')->name('admin.ticket.edit')->middleware('admin.permission:ticket.*');
    Route::post('/tickets/update/{ticket}', 'TicketController@update')->name('admin.ticket.update')->middleware('admin.permission:ticket.*');
    Route::get('/tickets/close/{ticket}', 'TicketController@close')->name('admin.ticket.close')->middleware('admin.permission:ticket.*');

    Route::get('/base', 'BaseServiceController@index')->name('admin.base_services')->middleware('admin.permission:service.*');
    Route::get('/base/create', 'BaseServiceController@create')->name('admin.base_service.create')->middleware('admin.permission:service.*');
    Route::post('/base/store', 'BaseServiceController@store')->name('admin.base_service.store')->middleware('admin.permission:service.*');
    Route::get('/base/edit/{service}', 'BaseServiceController@edit')->name('admin.base_service.edit')->middleware('admin.permission:service.*');
    Route::post('/base/update/{service}', 'BaseServiceController@update')->name('admin.base_service.update')->middleware('admin.permission:service.*');
    Route::get('/base/delete/{service}', 'BaseServiceController@remove')->name('admin.base_service.delete')->middleware('admin.permission:service.*');


    Route::get('/services/{carwash?}', 'ServiceController@services')->name('admin.services')->middleware('admin.permission:service.*');
    Route::get('/services/create/{carwash}', 'ServiceController@create')->name('admin.service.create')->middleware('admin.permission:service.*');
    Route::post('/services/store/{carwash}', 'ServiceController@store')->name('admin.service.store')->middleware('admin.permission:service.*');
    Route::get('/services/edit/{service}', 'ServiceController@edit')->name('admin.service.edit')->middleware('admin.permission:service.*');
    Route::post('/services/update/{service}', 'ServiceController@update')->name('admin.service.update')->middleware('admin.permission:service.*');
    Route::get('/services/delete/{service}', 'ServiceController@remove')->name('admin.service.delete')->middleware('admin.permission:service.*');

    Route::get('/reservations', 'ReservationController@index')->name('admin.reservations')->middleware('admin.permission:reservation.*');
    Route::get('/reservations/show/{reservation}', 'ReservationController@show')->name('admin.reservation.show')->middleware('admin.permission:reservation.*');
    Route::get('/reservations/update/{reservation}', 'ReservationController@update')->name('admin.reservation.update')->middleware('admin.permission:reservation.*');


    Route::get('/blogs', 'BlogController@index')->name('admin.blogs')->middleware('admin.permission:blog.*');
    Route::get('/blogs/create', 'BlogController@create')->name('admin.blog.create')->middleware('admin.permission:blog.*');
    Route::post('/blogs/store', 'BlogController@store')->name('admin.blog.store')->middleware('admin.permission:blog.*');
    Route::get('/blogs/edit/{blog}', 'BlogController@edit')->name('admin.blog.edit')->middleware('admin.permission:blog.*');
    Route::post('/blogs/update/{blog}', 'BlogController@update')->name('admin.blog.update')->middleware('admin.permission:blog.*');
    Route::get('/blogs/delete/{blog}', 'BlogController@delete')->name('admin.blog.delete')->middleware('admin.permission:blog.*');

    Route::get('/banks/{carwash?}', 'BankController@index')->name('admin.banks')->middleware('admin.permission:bank.*');
    Route::get('/banks/edit/{bank}', 'BankController@edit')->name('admin.bank.edit')->middleware('admin.permission:bank.*');
    Route::post('/banks/update/{bank}', 'BankController@update')->name('admin.bank.update')->middleware('admin.permission:bank.*');
    Route::get('/banks/delete/{bank}', 'BankController@delete')->name('admin.bank.delete')->middleware('admin.permission:bank.*');

    Route::get('/times/{carwash}', 'TimeController@index')->name('admin.times')->middleware('admin.permission:bank.*');
    Route::post('/times/update/{carwash}', 'TimeController@update')->name('admin.time.update');
    Route::get('/times/remove/{time}', 'TimeController@remove')->name('admin.time.remove');

    Route::get('/timetable/{carwash}', 'TimeController@timetable')->name('admin.timetable');
    Route::post('/timetable/update/{carwash}', 'TimeController@timetableUpdate')->name('admin.timetable.update');

    Route::get('/payments', 'PaymentController@payments')->name('admin.payments')->middleware('admin.permission:payment.*');
    Route::get('/releases', 'PaymentController@releases')->name('admin.releases')->middleware('admin.permission:payment.*');
    Route::get('/deposits', 'PaymentController@deposits')->name('admin.deposits')->middleware('admin.permission:payment.*');
    Route::get('/deposits/edit/{deposit}', 'PaymentController@edit_deposit')->name('admin.deposit.edit')->middleware('admin.permission:payment.*');
    Route::post('/deposits/update/{deposit}', 'PaymentController@update_deposit')->name('admin.deposit.update')->middleware('admin.permission:payment.*');

    Route::get('/products/{carwash?}', 'ProductController@index')->name('admin.products')->middleware('admin.permission:product.*');
    Route::get('/products/create/{carwash?}', 'ProductController@create')->name('admin.product.create')->middleware('admin.permission:product.*');
    Route::post('/products/store/{carwash?}', 'ProductController@store')->name('admin.product.store')->middleware('admin.permission:product.*');
    Route::get('/products/edit/{product}', 'ProductController@edit')->name('admin.product.edit')->middleware('admin.permission:product.*');
    Route::post('/products/update/{product}', 'ProductController@update')->name('admin.product.update')->middleware('admin.permission:product.*');
    Route::get('/products/delete/{product}', 'ProductController@delete')->name('admin.product.delete')->middleware('admin.permission:product.*');
    Route::get('/products/images/{product}', 'ProductController@images')->name('admin.product.images')->middleware('admin.permission:product.*');

    Route::get('/admins', 'AdminController@index')->name('admin.admins')->middleware('admin.permission:*');
    Route::get('/admins/edit/{administrator}', 'AdminController@edit')->name('admin.admin.edit')->middleware('admin.permission:*');
    Route::post('/admins/update/{administrator}', 'AdminController@update')->name('admin.admin.update')->middleware('admin.permission:*');
    Route::get('/admins/remove/{administrator}', 'AdminController@remove')->name('admin.admin.remove')->middleware('admin.permission:*');
    Route::get('/admins/create', 'AdminController@create')->name('admin.admin.create')->middleware('admin.permission:*');
    Route::post('/admins/store', 'AdminController@store')->name('admin.admin.store')->middleware('admin.permission:*');

    Route::get('/roles', 'RoleController@index')->name('admin.roles')->middleware('admin.permission:*');
    Route::get('/roles/edit/{role}', 'RoleController@edit')->name('admin.role.edit')->middleware('admin.permission:*');
    Route::post('/roles/update/{role}', 'RoleController@update')->name('admin.role.update')->middleware('admin.permission:*');
    Route::get('/roles/remove/{role}', 'RoleController@remove')->name('admin.role.remove')->middleware('admin.permission:*');
    Route::get('/roles/create', 'RoleController@create')->name('admin.role.create')->middleware('admin.permission:*');
    Route::post('/roles/store', 'RoleController@store')->name('admin.role.store')->middleware('admin.permission:*');

    Route::get('/settings', 'SettingController@edit')->name('admin.settings')->middleware('admin.permission:*');
    Route::post('/settings', 'SettingController@update')->name('admin.settings.update')->middleware('admin.permission:*');

    Route::get('/categories', 'CategoryController@index')->name('admin.categories')->middleware('admin.permission:category.*');
    Route::get('/categories/edit/{category}', 'CategoryController@edit')->name('admin.category.edit')->middleware('admin.permission:category.*');
    Route::post('/categories/update/{category}', 'CategoryController@update')->name('admin.category.update')->middleware('admin.permission:category.*');
    Route::get('/categories/create', 'CategoryController@create')->name('admin.category.create')->middleware('admin.permission:category.*');
    Route::post('/categories/store', 'CategoryController@store')->name('admin.category.store')->middleware('admin.permission:category.*');
    Route::get('/categories/remove/{category}', 'CategoryController@remove')->name('admin.category.remove')->middleware('admin.permission:category.*');

});
