<?php

namespace App\ViewModels;

use Illuminate\Support\Carbon;
use Spatie\ViewModels\ViewModel;

class TvShowViewModel extends ViewModel
{
    public $tvshow;
    public function __construct($tv)
    {
        $this->tvshow = $this->formatTvShow($tv);
    }

    private function formatTvShow($tvShow)
    {
        return $tvShow->merge([
            'poster_path' => $tvShow['poster_path']
                ? 'https://image.tmdb.org/t/p/w500/'.$tvShow['poster_path']
                : 'https://via.placeholder.com/500x750',
            'vote_average' => $tvShow['vote_average'] * 10 .'%',
            'first_air_date' => Carbon::parse($tvShow['first_air_date'])->format('M d, Y'),
            'genres' => collect($tvShow['genres'])->pluck('name')->flatten()->implode(', '),
            'cast' => collect($tvShow['credits']['cast'])->take(5)->map(function($cast) {
                return collect($cast)->merge([
                    'profile_path' => $cast['profile_path']
                        ? 'https://image.tmdb.org/t/p/w300'.$cast['profile_path']
                        : 'https://via.placeholder.com/300x450',
                ]);
            }),
            'images' => collect($tvShow['images']['backdrops'])->take(9),
        ])->only([
            'poster_path', 'id', 'genres', 'name', 'vote_average', 'overview', 'first_air_date', 'credits' ,
            'videos', 'images', 'crew', 'cast', 'images', 'created_by'
        ]);
    }
}
