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

//web accessible
Route::get('getTimetableDay/{department}/{year}', 'App\Http\Controllers\ApiController@getTimetableDay');
Route::get('getTimetableStudent/{firstName}/{lastName}', 'App\Http\Controllers\ApiController@getTimetableStudent');
Route::get('modifyNode/{department}/{year}/{dayName}/{classType}/{subjectName}/{nodeToModify}/{modification}', 'App\Http\Controllers\ApiController@modifyNode');
Route::get('addStudent/{firstName}/{lastName}/{studentNumber}/{faculty}/{department}/{yearofstudy}', 'App\Http\Controllers\ApiController@addStudent');
Route::get('deleteStudent/{studentNumber}', 'App\Http\Controllers\Api2Controller@deleteStudent');

//curl and ajax request 
Route::post('request/getTimetableDay', 'App\Http\Controllers\Api2Controller@getTimetableDay');
Route::post('request/getTimetableStudent', 'App\Http\Controllers\Api2Controller@getTimetableStudent');
Route::post('request/modifyNode', 'App\Http\Controllers\Api2Controller@modifyNode');
Route::post('request/addStudent', 'App\Http\Controllers\Api2Controller@addStudent');
Route::post('request/deleteStudent', 'App\Http\Controllers\Api2Controller@deleteStudent');

//Route::get('students/{id}', 'ApiController@getStudent');
//Route::post('students', 'ApiController@createStudent');
//Route::put('students/{id}', 'ApiController@updateStudent');
//Route::delete('students/{id}','ApiController@deleteStudent');
