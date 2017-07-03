<?php

/*
|--------------------------------------------------------------------------
| Front-end Routes
|--------------------------------------------------------------------------
|
| These are all routes for the front-end. These
| do not need the Authenticate middleware
|
*/
Route::group(['middleware' => ['web']], function() {

    Route::get('/', 'FrontController@home');
    Route::get('post/{slug}', 'FrontController@post');

    Route::get('login', 'Cms\AuthController@getLogin');
    Route::get('logout', 'Cms\AuthController@getLogout');
    Route::post('login', 'Cms\AuthController@postLogin');
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
/**
 * TODO: check if id is digits only.
 * TODO: check if type param for post is valid.
 */
Route::group(['middleware' => ['web', 'auth']], function() {
    Route::get('cms', function(){
        return redirect('cms/post');
    });

    Route::get('cms/post', 'Cms\PostController@index');
    Route::get('cms/post/new', 'Cms\PostController@create');
    Route::get('cms/post/edit/{id}', 'Cms\PostController@edit');
    Route::get('cms/post/delete/{id}', 'Cms\PostController@destroy');

    Route::post('cms/post/store', 'Cms\PostController@store');

    //Slug check.
    Route::get('cms/post/slug', 'Cms\PostController@slug');
});