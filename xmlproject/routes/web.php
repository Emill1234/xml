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

Route::get('/modifynode', function() {
    return view('modifynode');
});

Route::get('/addstudent', function() {
    return view('addstudent');
});


Route::get('/deletestudent', function() {
    return view('deletestudent');
});

Route::get('parsing', 'App\Http\Controllers\XMLController@parsing');
Route::get('parsing2', 'App\Http\Controllers\XMLController@parsing2');
Route::get('validation', 'App\Http\Controllers\XMLController@validation');
Route::get('xslt', 'App\Http\Controllers\XMLController@xslt');

