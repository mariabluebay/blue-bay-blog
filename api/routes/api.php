<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::get('/posts', 'PostController@index');
Route::get('/posts/{post}', 'PostController@show');
Route::get('/user', 'AuthController@user')->middleware('auth:api');

Route::group([

    'middleware' => 'auth:api',
    'prefix' => 'posts'

], function () {

    Route::post('/', 'PostController@store');
    Route::patch('/{post}', 'PostController@update');
    Route::delete('/{post}', 'PostController@delete');

});
