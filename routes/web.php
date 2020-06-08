<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/business', function () {
    return view('welcome-business');
});

Auth::routes();

Route::prefix('company')->group(function() {
	Route::get('/login', 'Auth\CompanyLoginController@showLoginForm')->name('company.login');
	Route::post('/login', 'Auth\CompanyLoginController@login')->name('company.login.submit');
	Route::get('/register', 'Auth\CompanyRegisterController@showRegisterForm')->name('company.register');
	Route::post('/register', 'Auth\CompanyRegisterController@register')->name('company.register.submit');
});



Route::resources([
	'company' => 'HomeController',
	'company/bookings' => 'BookingController',
	'company/items' => 'Company\ItemController',
	'customers' => 'CustomerController',
    'customer/bookings' => 'CustomerBookingController',
    
]);


