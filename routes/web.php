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
Route::get('/', ['as' => 'welcome', 'uses' => 'ItemController@index']);
Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/bot_test', 'BotManController@botTest');
//Route::get('/botman/tinker', 'BotManController@tinker');

Auth::routes();

Route::group(['middleware' => 'web'], function () {
	Route::get('/contact', function () {
		return view('contact');
	});
	Route::get('/privacy', function () {
		return view('privacy');
	});
	Route::get('/terms', function () {
		return view('terms');
	});
	Route::get('/submit', function () {
		return view('item.submit');
	});
	Route::post('/submit', 'ItemController@createItemUser');
	Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
	Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
	Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);
	Route::get('/redirect/{provider}', 'SocialAuthController@redirect');
	Route::get('/callback/{provider}', 'SocialAuthController@callback');

	Route::get('/catalogue/{category?}', ['as' => 'catalogue', 'uses' => 'ItemController@getItemsByCategory']);
	Route::get('/style/{style?}', ['as' => 'style', 'uses' => 'ItemController@getItemsByStyle']);
	Route::get('/fabric/{fabric?}', ['as' => 'fabric', 'uses' => 'ItemController@getItemsByFabric']);

	Route::get('/item/like', 'ItemController@favItem');
	Route::get('/item/bookmark', 'ItemController@bookmarkItem');
	Route::get('/item/download', 'ItemController@downloadItem');
	Route::post('/item/comment', 'ItemController@makeCommentItem');
	Route::get('/item/{id}', ['as' => 'item', 'uses' => 'ItemController@getItem']);
	Route::post('search-suggestion', array('as' => 'search-suggestion', 'uses' => 'SearchController@searchSuggestion'));
	Route::get('/search', 'SearchController@search');
	Route::post('/designer-suggestion', 'DesignerController@getSuggestion');
	Route::get('/designer-suggestion', 'DesignerController@getSuggestion');
});

Route::group(['middleware' => ['auth']], function () {

	Route::get('/item/{id}/make', ['as' => 'make_item', 'uses' => 'ItemController@makeItem']);
	Route::post('/item/{id}/make', ['as' => 'make_item', 'uses' => 'RequestController@makeItem']);

	Route::get('/home', 'ItemController@index')->name('home');
	Route::get('/bookmarks', 'UserController@getBookmarks');
	Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

	Route::get('/account', 'UserController@showProfile')->name('profile');
	Route::post('/account/upload', 'UserController@postUpload');
	Route::post('/account', 'UserController@updateUser');
});

Route::group(['middleware' => ['auth', 'currentUser']], function () {

});

Route::get('/styles/build', function () {
	return view('item.new');
});
Route::get('/styles/excel_build', function () {
	return view('item.new_excel');
});

Route::post('/styles/build', 'ItemController@createItem');
Route::post('/styles/excel_build', 'ItemController@createItemExcel');
