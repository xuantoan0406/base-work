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

Route::namespace('Api')->group(function () {
    Route::post('auth/login', 'AuthController@login');
    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Auth routes
        Route::apiResource('users', 'UserController');
        Route::apiResource('statuses', 'StatusController');
        Route::apiResource('places','PlacesController');
        Route::apiResource('activity', 'ActivityController');
        Route::post('endActivity','ActivityController@endActivity');
        Route::apiResource('workplace', 'WorkplaceController');

        Route::apiResource('notes','NotesController');
        Route::get('listNotesRecently','NotesController@listNotesRecently');
        Route::post('getNoteUserSelect','NotesController@noteUserSelect');

        Route::post('updateInformation','UserController@updateInformation');
        Route::get('auth/user','AuthController@user');
        Route::post('auth/logout','AuthController@logout');

        Route::post('getActivityByDate','ActivityController@getActivityByDate');
        Route::get('getListUsersWithWorkplaces','UserController@getListUsersWithWorkplaces');
        Route::get('getListUsersWithActivity','UserController@getListUsersWithActivity');
        Route::get('getListUserFilterByStatus','UserController@getListUserFilterByStatus');
        Route::get('getListUserFilterByPlace','UserController@getListUserFilterByPlace');
        Route::get('getUsersOrderByName','UserController@getUsersOrderByName');
        Route::get('getAllPlaces','PlacesController@getAll');

        Route::get('getActInFourDaysPrevious','ActivityController@getActInFourDaysPrevious');
        Route::get('getActTodayByAuth','ActivityController@getActTodayByAuth');
        Route::get('getActOfMonth','ActivityController@getActOfMonth');
    });
});

