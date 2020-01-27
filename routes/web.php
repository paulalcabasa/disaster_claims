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

Route::get('/', 'RedirectController@redirect_login');
Route::get('redirect_logout', 'RedirectController@redirect_logout')->name('redirect_logout');

Route::middleware(['auth:oracle_users,web'])->group(function () { //--> Authenticated Users
	
	Route::view('claim-entry', 'claim_entry')->name('claim-entry'); //->name('dashboard');
	Route::view('claim-list', 'claim_list')->name('claim-list'); //->name('dashboard');

	Route::get('vehicle/search/{cs_no}','VehicleController@get');
	Route::get('parts/get/{model_id}','ModelPartsController@get');

	Route::post('claim/submit','ClaimsController@store');
	Route::get('claims/get','ClaimsController@getClaims');
	Route::get('claims/get/{claim_header_id}','ClaimsController@show');


;});

Route::get('login/{user_id}', 'Auth\LoginController@authenticate')->name('api_login');
Route::get('logout', 'Auth\LogoutController@logout')->name('api_logout');