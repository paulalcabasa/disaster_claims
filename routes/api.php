<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('export-travis-rs', 'ReportsController@exportTravisRs')->name('reports.export_travis_rs');
Route::get('export-travis-pullout', 'ReportsController@exportTravizPullout')->name('reports.export_travis_pullout');

Route::get('traviz/get-details/{searchParam}', 'TravizController@findVehicle');
Route::post('inquiry/submit', 'InquiryController@store');