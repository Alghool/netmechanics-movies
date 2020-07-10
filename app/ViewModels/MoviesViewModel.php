<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class MoviesViewModel extends ViewModel
{
    public $popularMovies;
    public $topRatedMovies;
    public $nowPlayingMovies;
    public $genres;

    public function __construct($popularMovies, $nowPlayingMovies, $topRatedMovies, $genres)
    {
        $this->genres = $this->formatGenres($genres);
        $this->popularMovies = $this->formatMovies($popularMovies);
        $this->topRatedMovies = $this->formatMovies($nowPlayingMovies);
        $this->nowPlayingMovies = $this->formatMovies($topRatedMovies);
    }

    private function formatMovies($movies){
        return $movies->map(function($movie){
            return collect($movie)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/w500/'.$movie['poster_path'],
                'vote_average' => $movie['vote_average'] * 10 .'%',
                'release_date' => Carbon::parse($movie['release_date'])->format('M d, Y'),
                'genres' =>   $this->formatedMovieGenreStr($movie)
            ])->only([
                'id', 'title', 'genres', 'poster_path', 'vote_average', 'release_date', 'overview'
            ]);
        });
    }

    private function formatGenres($genres){
        return $genres->mapWithKeys(function($genre){
            return [$genre['id'] => $genre['name']];
        });
    }

    private function formatedMovieGenreStr($movie){
        return collect($movie['genre_ids'])->mapWithKeys(function ($genreID){
            return [$genreID=>$this->genres[$genreID]];
        })->implode(', ');
    }
}
