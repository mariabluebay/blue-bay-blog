<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::get('/posts', 'PostController@index');
Route::get('/posts/{post}', 'PostController@show');


Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::post('/logout', 'AuthController@logout');

    Route::get('/user', 'AuthController@user');

    Route::post('/posts/', 'PostController@store');
    Route::patch('/posts/{post}', 'PostController@update');
    Route::delete('/posts/{post}', 'PostController@delete');

    Route::get('/profiles/{user}', 'ProfileController@show');

});
