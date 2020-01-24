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

Route::middleware(['auth:oracle_users,web'])->group(function () { //--> Authenticated Users

});

Route::get('login/{user_id}', 'Auth\LoginController@authenticate');
Route::get('logout', 'Auth\LogoutController@logout')->name('api_logout');