<?php

use Illuminate\Support\Facades\Route;

Route::get('/','MoviesController@index')->name("movies.index");
Route::get('/show/{movie}','MoviesController@show')->name("movies.show");

Route::get('/actors','ActorsController@index')->name("actors.index");
Route::get('/actors/page/{page?}', 'ActorsController@index');
Route::get('/actors/show/{Actor}','ActorsController@show')->name("actors.show");