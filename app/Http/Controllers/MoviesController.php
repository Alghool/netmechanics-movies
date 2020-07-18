<?php

namespace App\Http\Controllers;


use App\ViewModels\MoviesViewModel;
use App\ViewModels\MovieViewModel;

class MoviesController extends Controller
{

    public function index()
    {
        $tmdb = resolve('tmdb');

        $popularMovies = $tmdb->popularMovies()->getResult()->take(10);
        $topRatedMovies = $tmdb->moviesTopRated()->getResult()->take(10);
        $nowPlayingMovies = $tmdb->moviesNowPlaying()->getResult()->take(10);
        $genres = $tmdb->moviesGenre()->get();



        $moviesViewModel = new MoviesViewModel(
            $popularMovies,
            $nowPlayingMovies,
            $topRatedMovies,
            $genres
        );

         return view('movies.index',$moviesViewModel);

    }

    public function show($id)
    {
        $tmdb = resolve('tmdb');

        $movie = $tmdb->with(['credits','videos','images'])->movie($id)->get();
        return view('movies.show',new MovieViewModel($movie));
     }

}
