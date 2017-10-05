<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
	Route::post('/login', 'Api\AuthController@login');
	Route::post('/register', 'Api\AuthController@register');
	Route::post('/social_login', 'Api\AuthController@socialLogin');

	Route::get('/items', 'Api\ItemController@index');
	Route::post('/items', 'Api\ItemController@store');
	Route::get('/items/latest', 'Api\ItemController@index');
	Route::get('/items/popular', 'Api\ItemController@popular');
	Route::get('/items/top_rated', 'Api\ItemController@topRated');
	Route::get('/items/top_downloads', 'Api\ItemController@topDownloads');
	Route::get('/items/{id}', 'Api\ItemController@show');
	Route::get('/items/{id}/similar', 'Api\ItemController@similar');
	Route::get('/items/{id}/comments', 'Api\CommentController@index');
	Route::post('/items/{id}/comments', 'Api\CommentController@create');
	Route::get('/items/{id}/user', 'Api\UserController@index');
	//Route::put('/items/{id}', 'Api\ItemController@update');
	Route::delete('/items/{id}', 'Api\ItemController@destroy');

	Route::get('/users/{id}', 'Api\ActorController@show');
	Route::get('/users/{id}/bookmarks', 'Api\ItemController@bookmarks');
	Route::get('/users/{id}/uploads', 'Api\ItemController@myItems');

	Route::group(['middleware' => ['auth:api']], function () {
		Route::post('logout', 'Api\AuthController@logout');

		Route::get('/items/recommended', 'Api\ItemController@recommended');
	});
});
