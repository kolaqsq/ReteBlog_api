<?php

use Illuminate\Support\Facades\Route;

Route::post('articles', 'ArticleController@store');
Route::put('articles/{slug}', 'ArticleController@update');
Route::delete('articles/{slug}', 'ArticleController@delete');

Route::post('articles/{slug}/files', 'ArticleController@uploadFile');
Route::delete('articles/{slug}/files', 'ArticleController@deleteFile');
