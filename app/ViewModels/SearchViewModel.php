<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;

class SearchViewModel extends ViewModel
{
    public  $searchResults;
    public function __construct($searchResult)
    {
        $this->searchResults = $this->formatResult($searchResult);
    }

    private function formatResult($results){
        return $results->map(function($result){
            $data = [];
           switch ($result['media_type']){
               case 'movie':
                    $data = [
                        'poster' => $result['poster_path']
                            ?'https://image.tmdb.org/t/p/w92/' .$result['poster_path']
                            :asset('img/placeholder.png'),
                        'name' => $result['title'],
                        'link' => route('movies.show', $result['id']),
                        'type' => 'movie'
                    ];
                    break;
               case 'tv':
                   $data = [
                       'poster' => $result['poster_path']
                           ?'https://image.tmdb.org/t/p/w92/' .$result['poster_path']
                           :asset('img/placeholder.png'),
                       'name' => $result['name'],
                       'link' => route('tv.show', $result['id']),
                       'type' => 'tv'
                   ];
                   break;
               case 'person':
                   $data = [
                       'poster' => $result['profile_path']
                           ?'https://image.tmdb.org/t/p/w92/' .$result['profile_path']
                           :asset('img/placeholder.png'),
                       'name' => $result['name'],
                       'link' => route('actors.show', $result['id']),
                       'type' => 'actor'
                   ];
                   break;
           }
           $data['poster'] = $data['poster'] ?? asset('img/placeholder.png');

            return collect($data);
        });
    }
}
