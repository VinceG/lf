<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('me', 'AuthController@me');
});

Route::resource('users', 'UsersController')->except(['create', 'edit', 'destroy']);
Route::resource('posts', 'PostsController')->except(['create', 'edit']);
Route::resource('posts.files', 'FilesController')->except(['create', 'edit']);
Route::resource('posts.tags', 'TagsController')->except(['create', 'edit']);
