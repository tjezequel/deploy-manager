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

Route::middleware(['auth:api'])->group(function(){
    Route::namespace('API')->group(function(){

        /*
         * Languages Routes
         */
        Route::get('/language','LanguageController@list');
        Route::post('/language', 'LanguageController@create');
        Route::put('/language/{languageId}', 'LanguageController@update');
        Route::delete('/language/{languageId}', 'LanguageController@delete');

        /*
         * Framework Routes
         */
        Route::get('/framework','FrameworkController@list');
        Route::post('/framework', 'FrameworkController@create');
        Route::put('/framework/{frameworkId}', 'FrameworkController@update');
        Route::delete('/framework/{frameworkId}', 'FrameworkController@delete');

        /*
         * Application Routes
         */
        Route::get('/app','ApplicationController@list');
        Route::post('/app', 'ApplicationController@create');
        Route::put('/app/{applicationId}', 'ApplicationController@update');
        Route::delete('/app/{applicationId}', 'ApplicationController@delete');
        Route::get('/app/{applicationId}', 'ApplicationController@detail');

        /*
         * Teams Route
         */
        Route::get('/team', 'TeamController@teams');
        Route::get('/team/apps', 'TeamController@teamApps');

    });
});
