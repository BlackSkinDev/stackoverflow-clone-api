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
              Route::post('/register', 'UserController@register')->name('register');
              Route::post('/login', 'UserController@login')->name('login');
        });

        //protected routes
        Route::middleware(['myapi'])->group(function () {

            // question related endpoints
            Route::prefix('question')->group(function () {

                //endpoint to post a new question
                Route::post('/create', 'QuestionController@store')->name('store-question');

                //endpoint to upvote a question
                Route::get('{question}/upvote', 'QuestionController@upvote')->name('upvote-question');

                //endpoint to downvote  a question
                Route::get('{question}/downvote', 'QuestionController@downvote')->name('downvote-question');


            });


            // answer related endpoints
            Route::prefix('answer')->group(function () {

                //endpoint to post a answer for a question
                Route::post('{question}/reply', 'AnswerController@reply')->name('send-reply');

            });




        });

});
