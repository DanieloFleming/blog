<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function() {

    Route::get('/', 'FrontController@home');
    Route::get('post/{slug}', 'FrontController@post');


    Route::get('login', 'Cms\AuthController@getLogin');
    Route::post('login', 'Cms\AuthController@postLogin');
    Route::get('logout', 'Cms\AuthController@getLogout');


});


Route::group(['middleware' => ['web', 'auth']], function() {
    Route::get('cms/dashboard', 'Cms\DashboardController@index');

    Route::get('cms/post', 'Cms\PostController@index');
    Route::get('cms/post/new', 'Cms\PostController@create');
    Route::get('cms/post/edit/{id}', 'Cms\PostController@edit');
    Route::get('cms/post/delete/{id}', 'Cms\PostController@destroy');
    Route::post('cms/post/store/', 'Cms\PostController@store');

    Route::get('cms/post/slug', 'Cms\PostController@slug');
});