<?php
namespace App\servers;

use Illuminate\Support\Facades\Http;
class Tmdb
{
    private $http;
    private $response = null;
    private $resultKey = null;
    private $returnType = 'collection';
    private $append = [];

    private $popularMovies = 'movie/popular';
    private $moviesGenre = 'genre/movie/list';
    private $moviesNowPlaying = 'movie/now_playing';
    private $moviesTopRated = 'movie/top_rated';
    private $movie = 'movie/';

    public function __construct( )
    {
        $this->http = Http::withToken(config('services.tmdb.token'));
    }

    public function getResponse(){
        $this->clear();
        return $this->cast($this->response);
    }

    public function getResult(){
        $this->clear();
        return $this->cast($this->response[$this->resultKey] ?? $this->response);
    }

    public function get(){
        return $this->getResult();
    }

    public function with($append){
        if(is_array($append)){
            $this->append = array_merge($this->append, $append);
        }
        else{
            $this->append[] = $append;
        }
        return $this;
    }

    public function moviesGenre(){
        $this->callServer($this->moviesGenre, 'genres');
        return $this;
    }

    public function movie($movieID){
        $this->callServer($this->movie.$movieID, '');
        return $this;
    }

    public function popularMovies(){
        $this->callServer($this->popularMovies, 'results');
        return $this;
    }

    public function moviesNowPlaying(){
        $this->callServer($this->moviesNowPlaying, 'results');
        return $this;
    }

    public function moviesTopRated(){
        $this->callServer($this->moviesTopRated, 'results');
        return $this;
    }

    private function callServer($endPoint, $resultKey){
        $this->response = $this->http->get(Config('services.tmdb.link').$endPoint.$this->getAppendString())->json();
        $this->resultKey = $resultKey;
    }

    private function cast($resultArray){
        return $this->returnType == 'collection' ? collect($resultArray) : $resultArray;
    }

    private function clear(){
        $this->append = [];
    }

    private function getAppendString(){
        $return = '';
        if(!empty($this->append)){
            $return = '?append_to_response=';
            foreach ($this->append as $append){
                $return .= $append .',';
            }
            $return = substr($return, 0, -1);
        }
        return $return;
    }
}