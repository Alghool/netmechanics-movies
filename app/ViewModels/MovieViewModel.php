<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class MovieViewModel extends ViewModel
{
    public $movie;
    public function __construct($movie)
    {
        $this->movie = $this->formatMovie($movie);
    }

    private function formatMovie($movie){
        return collect($movie)->merge([
            'poster_path' => 'https://image.tmdb.org/t/p/w500/'.$movie['poster_path'],
            'vote_average' => $movie['vote_average'] * 10 .'%',
            'release_date' => Carbon::parse($movie['release_date'])->format('M d, Y'),
            'genres' =>   collect($movie['genres'])->pluck('name')->flatten()->implode(','),
            'crew' => collect($movie['credits']['crew'])->take(2),
            'cast' => collect($movie['credits']['cast'])->map(function($cast){
                return collect($cast)->merge([
                   'profile_path' => $cast['profile_path']
                       ?'https://image.tmdb.org/t/p/w300/'.$cast['profile_path']
                       :asset('img/placeholder.png')
                ]);
            })->take(5),
            'images' => collect($movie['images']['backdrops'])->take(9),
        ])->only([
            'id', 'title', 'genres', 'poster_path', 'vote_average', 'release_date', 'overview',
            'videos', 'crew', 'cast', 'images'
        ]);
    }
}
