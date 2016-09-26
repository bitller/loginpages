<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'LandingController@index');

Route::group(['prefix' => 'submit'], function() {
    Route::get('/', 'SubmitController@index');
    Route::post('/', 'SubmitController@submitPage');
});

Route::group(['prefix' => 'random'], function() {
    Route::get('/', 'RandomController@index');
});

Route::group(['prefix' => 'favorites'], function() {
    Route::get('/', 'FavoritesController@index');
    Route::post('/add', 'FavoritesController@addPageToFavorites');
    Route::post('/remove', 'FavoritesController@removePageFromFavorites');
});

Route::group(['prefix' => 'auth'], function() {
    Route::get('github', 'AuthController@redirectToGithubProvider');
    Route::get('github/callback', 'AuthController@handleGithubProviderCallback');
    Route::get('google', 'AuthController@redirectToGoogleProvider');
    Route::get('google/callback', 'AuthController@handleGoogleProviderCallback');
    Route::get('facebook', 'AuthController@redirectToFacebookProvider');
    Route::get('facebook/callback', 'AuthController@handleFacebookProviderCallback');
    Route::get('logout', 'AuthController@logout');
});

/**
 * Admin center section. Only authenticated users with admin role have access.
 */
Route::group(['prefix' => 'admin-center', 'namespace' => 'AdminCenter', 'middleware' => ['auth', 'admin']], function() {
    // Submited pages
    Route::group(['prefix' => 'submited-pages'], function() {
        Route::get('/', 'SubmitedPagesController@index');
        Route::post('/{pageId}/accept', 'SubmitedPagesController@acceptPage');
        Route::post('/{pageId}/decline', 'SubmitedPagesController@declinePage');
    });

    // Upload page
    Route::group(['prefix' => 'upload-page'], function() {
        Route::get('/get-page-details/{pageId}', 'UploadPageController@getPage');
        Route::post('/', 'UploadPageController@uploadPage');
    });

    // Users
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UsersController@index');
        Route::post('/enable-account', 'UsersController@enableAccount');
        Route::post('/disable-account', 'UsersController@disableAccount');
    });
});
