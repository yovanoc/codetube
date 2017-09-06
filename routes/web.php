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

Route::view('/', 'welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/webhook/encoding', 'EncodingWebhookController@handle');

Route::get('/search', 'SearchController@index');

Route::post('/videos/{video}/views', 'VideoViewController@create')->name('videos.view');

Route::get('/videos/{video}/votes', 'VideoVoteController@show');

Route::get('/videos/{video}/comments', 'VideoCommentController@index');

Route::get('/subscription/{channel}', 'ChannelSubscriptionController@show');

Route::resource('channels', 'ChannelController');
Route::resource('videos', 'VideoController');

Route::get('/upload', 'VideoUploadController@index')->name('videos.upload.index');
Route::post('/upload', 'VideoUploadController@store')->name('videos.upload.store');

Route::post('videos/{video}/votes', 'VideoVoteController@create');
Route::delete('videos/{video}/votes', 'VideoVoteController@delete');

Route::post('/videos/{video}/comments', 'VideoCommentController@create');
Route::delete('/videos/{video}/comments/{comment}', 'VideoCommentController@delete');

Route::post('/subscription/{channel}', 'ChannelSubscriptionController@create');
Route::delete('/subscription/{channel}', 'ChannelSubscriptionController@delete');
