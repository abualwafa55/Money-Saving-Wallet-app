<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('auth/register','AuthController@register');

Route::post('auth/login','AuthController@login');

Route::post('goals/create', 'GoalsController@create');
Route::get('goals', 'GoalsController@index');
Route::get('goals/{id}', 'GoalsController@view_detail');
Route::post('goals/delete/{id}', 'GoalsController@delete');
Route::post('goals/update', 'GoalsController@update');

Route::post('records/create', 'RecordsController@create');
Route::get('records','RecordsController@index');
Route::get('records/catgory','RecordsController@get_goals_category');
Route::get('records/{id}', 'RecordsController@view_detail');
Route::post('records/delete/{id}', 'RecordsController@delete');
Route::post('records/update', 'RecordsController@update');

Route::get('chart','ChartsController@index');

Route::get('currency','CurrencyController@getCurrency');

