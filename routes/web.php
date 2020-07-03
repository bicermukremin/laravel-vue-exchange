<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response($request->user());
});

Route::prefix('app')->group(function () {
    Route::resource('exchanges', 'FrontEnd\ExchangeController');


    Route::resource('roles', 'Admin\RoleController');
    Route::resource('users', 'Admin\UserController');
    Route::resource('opportunities', 'Frontend\OpportunityController');
    /* Route::post('assign_roles', 'Admin\RoleController@assignRole');
     */
    Route::post('send-token', 'Admin\UserController@sendToken');
    Route::post('validate-token', 'Admin\UserController@validateToken');
    Route::post('reset-password', 'Admin\UserController@resetPassword');
    Route::get('/permission', 'Admin\RoleController@permission');
    Route::get('/isAdmin', 'Admin\RoleController@isAdmin');
    Route::patch('/updateProfile/{id}', 'Admin\UserController@updateProfile');
});

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.-]*');

Auth::routes();