<?php

use Illuminate\Support\Facades\Route;

Route::get('/','MoviesController@index')->name("movies.index");
Route::get('/show/{movie}','MoviesController@show')->name("movies.show");


