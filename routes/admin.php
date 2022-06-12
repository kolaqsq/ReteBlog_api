<?php

use Illuminate\Support\Facades\Route;

Route::post('articles', 'ArticleController@store');
Route::put('articles/{slug}', 'ArticleController@update');
Route::delete('articles/{slug}', 'ArticleController@delete');
