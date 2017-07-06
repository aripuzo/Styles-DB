<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/catalogue/{category?}', ['as' => 'catalogue', 'uses' => 'ItemController@getItems']);

Route::get('/style/{style?}', ['as' => 'style', 'uses' => 'ItemController@getItems']);

Route::get('/fabric/{fabric?}', ['as' => 'fabric', 'uses' => 'ItemController@getItems']);

Route::get('/search', 'ItemController@searchItems');

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/portfolio', function () {
    return view('portfolio');
});

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
