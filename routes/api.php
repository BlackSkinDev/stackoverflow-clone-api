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

Route::namespace('Api')->group(function(){

        Route::prefix('auth')->group(function () {

            // register and login routes
              Route::post('/register', 'UserController@register');
              Route::post('/login', 'UserController@login');
        });

        //protected routes
        Route::middleware(['myapi'])->group(function () {

            Route::prefix('questions')->group(function () {

                //endpoint to post a new question
                Route::post('/create', 'QuestionController@store');
            });


        });

});
