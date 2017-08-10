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

Route::get('/', 'ItemController@index');

Route::get('/catalogue/{category?}', ['as' => 'catalogue', 'uses' => 'ItemController@getItemsByCategory']);

Route::get('/style/{style?}', ['as' => 'style', 'uses' => 'ItemController@getItems']);

Route::get('/fabric/{fabric?}', ['as' => 'fabric', 'uses' => 'ItemController@getItems']);

Route::get('/item/like', 'ItemController@favItem')->middleware('auth');

Route::get('/item/bookmark', 'ItemController@bookmarkItem')->middleware('auth');

Route::get('/item/download', 'ItemController@downloadItem')->middleware('auth');

Route::post('/item/comment', 'ItemController@makeCommentItem')->middleware('auth');

Route::get('/item/{id}', ['as' => 'item', 'uses' => 'ItemController@getItem']);

Route::get('/item/{id}/make', ['as' => 'make_item', 'uses' => 'ItemController@makeItem'])->middleware('auth');

Route::post('/item/{id}/make', ['as' => 'make_item', 'uses' => 'RequestController@makeItem'])->middleware('auth');

Route::get('search-suggestion', array('as'=>'search-suggestion','uses'=>'ItemController@searchSuggestion'));

Route::get('/search', 'ItemController@searchItems');

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/send', function () {
    return view('send');
});

Route::get('/redirect/{provider}', 'SocialAuthController@redirect');
Route::get('/callback/{provider}', 'SocialAuthController@callback');

Auth::routes();

Route::get('/styles/build', function () {
    return view('item.new');
});
Route::get('/styles/excel_build', function () {
    return view('item.new_excel');
});

Route::post('/styles/build', 'ItemController@createItem');
Route::post('/styles/excel_build', 'ItemController@createItemExcel');

Route::get('/home', 'ItemController@index')->name('home');
Route::get('/account', 'UserController@showProfile')->name('profile');
Route::post('/account', 'UserController@updateUser');
Route::get('/bookmarks', 'UserController@getBookmarks');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
