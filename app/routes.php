<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('prefix'=>'oauth2'), function(){
    Route::get('/authorize', 'OAuth2Controller@getAuthorize');
    Route::post('/authorize', 'OAuth2Controller@postAuthorize');
    Route::get('/test-authorize', 'OAuth2Controller@getTestAuthorize');
    Route::post('/test-authorize', 'OAuth2Controller@postTestAuthorize');
    Route::post('/access_token', 'OAuth2Controller@postAccessToken');
    Route::get('/user', 'OAuth2Controller@getUser');
});
