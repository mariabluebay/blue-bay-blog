<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::get('/posts', 'PostController@index');
Route::get('/posts/{post}', 'PostController@show');


Route::group([
    'middleware' => ['auth:api','cors'],
], function () {
    Route::post('/logout', 'AuthController@logout');

    Route::get('/user', 'AuthController@user');

    Route::post('/posts/', 'PostController@store');
    Route::patch('/posts/{post}', 'PostController@update');
    Route::delete('/posts/{post}', 'PostController@delete');

    Route::patch('/profiles','ProfileController@update');
    Route::get('/profiles/{user:username}', 'ProfileController@show');

    Route::post('/profiles/{user:username}/follow', 'FollowsController@store');
});
