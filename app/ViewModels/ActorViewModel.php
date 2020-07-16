<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Ramsey\Collection\Collection;
use Spatie\ViewModels\ViewModel;

class ActorViewModel extends ViewModel
{
    public $actor;
    public $social;
    public $knownForMovies;
    public $credits;

    public function __construct($actor)
    {
        $this->social = $this->formatSocial(collect($actor['external_ids']));
        $this->knownForMovies = $this->formatKnownForMovies(collect($actor['combined_credits']['cast']));
        $this->credits = $this->formatCredits(collect($actor['combined_credits']['cast']));
        $this->actor = $this->formatActor($actor);

    }

    private function formatActor( $actor){
        return $actor->merge([
            'birthday' => Carbon::parse($actor['birthday'])->format('M d, Y'),
            'age' => Carbon::parse($actor['birthday'])->age,
            'profile_path' => $actor['profile_path']
                ?'https://image.tmdb.org/t/p/w300/'.$actor['profile_path']
                :asset('img/placeholder.png'),
        ])->only([
            'birthday', 'age', 'profile_path', 'name', 'id', 'homepage', 'place_of_birth', 'biography'
        ]);
    }

    private function formatSocial($social){
        return $social->merge([
            'twitter' => $social['twitter_id'] ? 'https://twitter.com/'.$social['twitter_id'] : null,
            'facebook' => $social['facebook_id'] ? 'https://facebook.com/'.$social['facebook_id'] : null,
            'instagram' => $social['instagram_id'] ? 'https://instagram.com/'.$social['instagram_id'] : null,
        ])->only([
            'facebook', 'instagram', 'twitter',
        ]);
    }

    private function formatKnownForMovies($cast){
        return $cast->where('media_type', 'movie')->sortByDesc('popularity')->take(5)
            ->map(function($movie) {
                return collect($movie)->merge([
                    'poster_path' => $movie['poster_path']
                        ? 'https://image.tmdb.org/t/p/w185'.$movie['poster_path']
                        : asset('img/placeholder.png'),
                    'title' => isset($movie['title']) ? $movie['title'] : 'Untitled',
                ])->only([
                    'poster_path', 'title', 'id', 'media_type'
                ]);
            });
    }

    private function formatCredits($cast){
        return $cast->map(function($movie) {
            if (isset($movie['release_date'])) {
                $releaseDate = $movie['release_date'];
            } elseif (isset($movie['first_air_date'])) {
                $releaseDate = $movie['first_air_date'];
            } else {
                $releaseDate = '';
            }

            if (isset($movie['title'])) {
                $title = $movie['title'];
            } elseif (isset($movie['name'])) {
                $title = $movie['name'];
            } else {
                $title = 'Untitled';
            }

            return collect($movie)->merge([
                'release_date' => $releaseDate,
                'release_year' => isset($releaseDate) ? Carbon::parse($releaseDate)->format('Y') : 'Future',
                'title' => $title,
                'character' => isset($movie['character']) ? $movie['character'] : '',
            ])->only([
                'release_date', 'release_year', 'title', 'character',
            ]);
        })->sortByDesc('release_date');
    }
}
