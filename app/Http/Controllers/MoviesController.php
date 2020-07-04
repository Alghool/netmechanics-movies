<?php

namespace App\Http\Controllers;


class MoviesController extends Controller
{

    public function index()
    {
        $tmdb = resolve('tmdb');

        $popularMovies = $tmdb->popularMovies()->getResult()->slice(0,10);
        $topRatedMovies = $tmdb->moviesTopRated()->getResult()->slice(0,10);
        $nowPlayingMovies = $tmdb->moviesNowPlaying()->getResult()->slice(0,10);
        $genresArray = $tmdb->moviesGenre()->get();

        $genres = collect($genresArray)->mapWithKeys(function($genre){
            return [$genre['id'] => $genre['name']];
        });

        $data = [
            'popularMovies' => $popularMovies,
            'nowPlayingMovies' => $nowPlayingMovies,
            'topRatedMovies' => $topRatedMovies,
            'genres' => $genres
        ];

         return view('index',$data);

    }

    public function show($id)
    {
        $tmdb = resolve('tmdb');

        $movie = $tmdb->with(['credits','videos','images'])->movie($id)->get();

        return view('show',['movie' => $movie]);
     }

}
