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

Route::get('/forums', 'Api\ForumController@index');
Route::get('/forums/{forum}', 'Api\ForumController@show');

Route::get('/posts', 'Api\PostController@index');
Route::get('/posts/{post}', 'Api\PostController@show');

Route::get('/replies', 'Api\ReplyController@index');
Route::get('/replies/{reply}', 'Api\ReplyController@show');
