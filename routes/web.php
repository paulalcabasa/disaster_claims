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
Route::get('TravizServiceCampaign2020', 'TravizController@service_campaign2020');

Route::middleware(['auth:oracle_users,web'])->group(function () { //--> Authenticated Users
	
	Route::get('dashboard','DashboardController@index')->name('dashboard');

	// user
	Route::view('claim-entry', 'claim_entry')->name('claim-entry'); //->name('dashboard');
	//Route::view('claim-list', 'claim_list')->name('claim-list'); //->name('dashboard');
	Route::get('claim-list', 'ClaimsController@getDealerClaims')->name('claim-list'); //->name('dashboard');

	Route::get('vehicle/search/{cs_no}','VehicleController@get');
	Route::get('parts/get/{model_id}','ModelPartsController@get');
	
	

	Route::post('claim/save','ClaimsController@store');
	Route::get('claims/get','ClaimsController@getClaims');
	Route::get('claims/get/{claim_header_id}','ClaimsController@show');
	Route::post('claims/update','ClaimsController@update');
	Route::post('claims/submit','ClaimsController@submit');

	// admin
//	Route::view('admin/claim-list','admin.claims')->name('admin-claims');
	Route::get('admin/claim-list','ClaimsController@getAllClaims')->name('admin-claims');
	//Route::get('admin/claims/get-all','ClaimsController@getAllClaims');
	//Route::view('admin/affected-units-list', 'admin.affected_units_list')->name('affected-units-list');
	Route::get('admin/affected-units-list', 'VehicleController@affectedUnits')->name('affected-units-list');
	Route::get('admin/claims/get/{claim_header_id}','ClaimsController@show');
	Route::get('admin/vehicle/get-affected-units','VehicleController@getAffectedUnits');
	Route::view('admin/models','admin.models')->name('models');
	Route::get('admin/models/get','ModelPartsController@getModelParts');
	Route::get('admin/parts/get/{model_id}','ModelPartsController@getParts');
	Route::get('admin/claims/stats','ClaimsController@getStatistics');

	Route::post('admin/parts/submit','ModelPartsController@store');

	Route::get('unclaimed-list','ClaimsController@unclaimed')->name('unclaimed-list');
	
	Route::get('profile','ProfileController@index')->name('profile');
	Route::post('profile/update/details','ProfileController@updateDetails');
	Route::post('profile/update/credentials','ProfileController@updateCredentials');

	Route::get('chrome','ModelPartsController@chromeMatrix')->name('chrome');
	Route::get('affected-units-chrome','ModelPartsController@affectedUnitsChrome')->name('affected-units-chrome');
});

Route::get('login/{user_id}', 'Auth\LoginController@authenticate')->name('api_login');
Route::get('logout', 'Auth\LogoutController@logout')->name('api_logout');