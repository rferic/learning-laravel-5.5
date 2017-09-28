<?php

use Illuminate\Support\Facades\Storage;

use Intervention\Image\Facades\Image;

use App\Http\Helpers\LanguageHelper;

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

/*Route::get('/', function () {
    return view('welcome');
});*/


/*Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
],
function()
{
});*/

Auth::routes();

Route::get('/', 'ForumController@index');
Route::get('/forums', 'ForumController@index');
Route::post('/forums', 'ForumController@store');
Route::get('/forums/clear_search', 'ForumController@clearSearch')->name('forums.clear_search');
Route::post('/forums/search', 'ForumController@search');
Route::get('/forums/{forum}', 'ForumController@show');

Route::get('/posts/{post}', 'PostController@show');
Route::post('/posts', 'PostController@store');
Route::delete('/posts/{post}', 'PostController@destroy');

Route::post('/replies', 'ReplyController@store');
Route::delete('/replies', 'ReplyController@destroy')->name('replies.delete');

// TODO Route of Images
Route::get('/images/{path}/{attachment}', function ($path, $attachment) {
    $storagePath = Storage::disk($path)->getDriver()->getAdapter()->getPathPrefix();
    $imageFilePath = $storagePath . $attachment;

    if (File::exists($imageFilePath))
    {
        return Image::make($imageFilePath)->response();
    }
});
