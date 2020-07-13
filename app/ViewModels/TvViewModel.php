<?php

namespace App\ViewModels;

use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;

class TvViewModel extends ViewModel
{
    public $popularTv;
    public $topRatedTv;
    public $genres;

    public function __construct($popularTv, $topRatedTv, $genres)
    {
        $this->genres = $this->formatGenres($genres);
        $this->popularTv = $this->formatTv($popularTv);
        $this->topRatedTv = $this->formatTv($topRatedTv);
    }


    private function formatTv($tv)
    {
        return $tv->map(function($tvshow) {
            return collect($tvshow)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/w500/'.$tvshow['poster_path'],
                'vote_average' => $tvshow['vote_average'] * 10 .'%',
                'first_air_date' => Carbon::parse($tvshow['first_air_date'])->format('M d, Y'),
                'genres' => $this->formattedMovieGenreSir($tvshow),
            ])->only([
                'poster_path', 'id', 'genre_ids', 'name', 'vote_average', 'overview', 'first_air_date', 'genres',
            ]);
        });
    }

    private function formatGenres($genres){
        return $genres->mapWithKeys(function($genre){
            return [$genre['id'] => $genre['name']];
        });
    }

    private function formattedMovieGenreSir($tv){
        return collect($tv['genre_ids'])->mapWithKeys(function ($genreID){
                return [$genreID=> $this->genres[$genreID]];
        })->implode(', ');
    }
}
