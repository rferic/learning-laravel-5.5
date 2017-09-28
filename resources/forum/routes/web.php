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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

Auth::routes();

Route::get('/set_language/{lang}', 'AppController@setLanguage')->name('set_language');

Route::get('/', 'ForumsController@index');
Route::get('/forums/{forum}', 'ForumsController@show');
Route::post('/forums', 'ForumsController@store');

Route::get('/posts/{post}', 'PostsController@show');
Route::post('/posts', 'PostsController@store');
Route::delete('/posts/{post}', 'PostsController@destroy');

Route::post('/replies', 'RepliesController@store');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.delete');

Route::get('/images/{path}/{attachment}', function($path, $attachment) {
	$storagePath = Storage::disk($path)->getDriver()->getAdapter()->getPathPrefix();
	$imageFilePath = $storagePath . $attachment;

	if(File::exists($imageFilePath)) {
		return Image::make($imageFilePath)->response();
	}
});