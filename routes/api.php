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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



    Route::group(['namespace'=>'Api'],function(){

    	Route::post('auth/register', 'UserController@register');
    	Route::post('auth/login', 'UserController@login');
    	Route::get('auth/me', 'UserController@getAuthUser');
    	Route::get('auth/logout', 'UserController@logout');
    	Route::get('auth/refresh', 'UserController@refreshToken');
        Route::post('auth/resetpassword', 'UserController@resetpassword');
    	Route::get('sss', 'UserController@sss');


    	Route::get('utilites','UtilitiesController@utilites');
        Route::get('departments','PagesController@department');
        Route::get('/departments/{dept}/{level_term?}/{course?}','PagesController@navUrl');
        Route::get('softwares','PagesController@software');
        Route::get('books','PagesController@book');
        Route::get('activities','PagesController@activities');
    	    

    
    });