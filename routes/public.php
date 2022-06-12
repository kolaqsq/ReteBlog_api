<?php

use Illuminate\Support\Facades\Route;

Route::post('username', 'AuthController@checkUsername');
Route::get('articles', 'ArticleController@listAll');
Route::get('articles/{slug}', 'ArticleController@showArticle');
Route::post('articles', 'ArticleController@search');
