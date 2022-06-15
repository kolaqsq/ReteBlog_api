<?php

use Illuminate\Support\Facades\Route;

Route::get('profile', 'UserController@profile');
Route::post('profile', 'UserController@update');
Route::post('file', 'FileController@upload');
Route::delete('file', 'FileController@delete');
