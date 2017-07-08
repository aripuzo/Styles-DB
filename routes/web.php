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
	if (Auth::check())
    	return view('user.home');
    else
    	return view('welcome');
});

Route::get('/catalogue/{category?}', ['as' => 'catalogue', 'uses' => 'ItemController@getItemsByCategory']);

Route::get('/style/{style?}', ['as' => 'style', 'uses' => 'ItemController@getItems']);

Route::get('/fabric/{fabric?}', ['as' => 'fabric', 'uses' => 'ItemController@getItems']);

Route::get('/item/{id}', ['as' => 'item', 'uses' => 'ItemController@getItem']);

Route::get('/item/{id}/download', ['as' => 'download', 'uses' => 'ItemController@downloadItem']);

Route::get('/item/like', 'ItemController@favItem');

Route::get('/search', 'ItemController@searchItems');

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/single', function () {
    return view('item.sigle');
});

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

Auth::routes();

Route::get('/styles/build', function () {
    return view('item.new');
});

Route::post('/styles/build', 'ItemController@createItem');

Route::get('/home', 'UserController@index')->name('home');
Route::get('/account', 'UserController@showProfile')->name('profile');
Route::post('/account', 'UserController@updateUser');
