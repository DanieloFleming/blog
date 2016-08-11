<?php

/*
|--------------------------------------------------------------------------
| Front-end Routes
|--------------------------------------------------------------------------
|
| These are all routes for the front-end. These
| do not need to the Authenticate middleware
|
*/
Route::group(['middleware' => ['web']], function() {

    Route::get('/', 'FrontController@home');
    Route::get('post/{slug}', 'FrontController@post');


    Route::get('login', 'Cms\AuthController@getLogin');
    Route::post('login', 'Cms\AuthController@postLogin');
    Route::get('logout', 'Cms\AuthController@getLogout');


});

/*
|--------------------------------------------------------------------------
| Back-end Routes
|--------------------------------------------------------------------------
|
| These are all routes for the back-end. In order to
| access these routes, the user must be logged in.
|
*/
Route::group(['middleware' => ['web', 'auth']], function() {
    Route::get('cms/dashboard', 'Cms\DashboardController@index');

    Route::get('cms/post', 'Cms\PostController@index');
    Route::get('cms/post/new', 'Cms\PostController@create');
    Route::get('cms/post/edit/{id}', 'Cms\PostController@edit');
    Route::get('cms/post/delete/{id}', 'Cms\PostController@destroy');
    Route::post('cms/post/store/', 'Cms\PostController@store');

    Route::get('cms/post/slug', 'Cms\PostController@slug');
});