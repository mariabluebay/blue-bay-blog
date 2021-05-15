<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::get('/user', 'AuthController@user')->middleware('auth:api');

Route::group([

    'middleware' => 'auth:api',
    'prefix' => 'posts'

], function () {

    Route::post('/', 'PostController@store');

});
