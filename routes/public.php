<?php

use Illuminate\Support\Facades\Route;

Route::post('username', 'AuthController@checkUsername');
Route::get('articles', 'ArticleController@listAll');
Route::get('articles/{slug}', 'ArticleController@showArticle');
Route::post('articles', 'ArticleController@search');
//Route::get('file/{filename?}', 'FileController@showFile')->where('filename', '(.*)');
