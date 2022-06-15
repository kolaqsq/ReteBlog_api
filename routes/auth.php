<?php

use Illuminate\Support\Facades\Route;

Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);
Route::post('register', 'AuthController@register');
