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

Route::get('get-service-points', 'ServicePointsController@getPoints');
Route::post('create-service-point', 'ServicePointsController@createPoint');
Route::post('create-service-group', 'ServicePointsController@createGroup');
Route::post('select-point', 'ServicePointsController@selectPoint');




Route::get('service-points', function (){
    return view('service_points');
});
