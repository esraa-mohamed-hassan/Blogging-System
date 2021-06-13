<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\PostsController@index');
Route::get('/home', ['as' => 'home', 'uses' => 'App\Http\Controllers\PostsController@index']);
Route::get('/logout', 'App\Http\Controllers\UsersController@logout');

Route::group(['prefix' => 'auth'], function () {
    Auth::routes();
});

// check for logged in user
Route::middleware(['auth'])->group(function () {
    // show new post form
    Route::get('new-post', 'App\Http\Controllers\PostsController@create');
    // save new post
    Route::post('new-post', 'App\Http\Controllers\PostsController@store');
    // edit post form
    Route::get('edit/{slug}', 'App\Http\Controllers\PostsController@edit');
    // update post
    Route::post('update', 'App\Http\Controllers\PostsController@update');
    // delete post
    Route::get('delete/{id}', 'App\Http\Controllers\PostsController@destroy');
    // display user's all posts
    Route::get('my-all-posts', 'App\Http\Controllers\UsersController@user_posts_all');
    // add comment
    Route::post('comment/add', 'App\Http\Controllers\CommentsController@store');
    // delete comment
    Route::post('comment/delete/{id}', 'App\Http\Controllers\CommentsController@distroy');
    //users profile
    Route::get('user/{id}', 'App\Http\Controllers\UsersController@profile')->where('id', '[0-9]+');
    //categories
    Route::resource('category', 'App\Http\Controllers\CategoryController');
    //Search by categories
    Route::get('searching', 'App\Http\Controllers\CategoryController@search');
});

// display list of posts
Route::get('user/{id}/posts', 'App\Http\Controllers\UsersController@user_posts')->where('id', '[0-9]+');
// display single post
Route::get('/{slug}', ['as' => 'post', 'uses' => 'App\Http\Controllers\PostsController@show'])->where('slug', '[A-Za-z0-9-_]+');
