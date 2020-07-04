<?php
namespace App\servers;

use Illuminate\Support\Facades\Http;
class Tmdb
{
    private $http;
    private $popularMovies = 'movie/popular';
    private $response = null;
    private $resultKey = null;

    public function __construct( )
    {
        $this->http = Http::withToken(config('services.tmdb.token'));
    }

    public function getResponse(){
        return $this->response;
    }

    public function getResult(){
        return $this->response[$this->resultKey] ?? $this->response;
    }

    public function popularMovies(){
        $this->callServer($this->popularMovies, 'results');
        return $this;
    }

    private function callServer($endPoint, $resultKey){
        $this->response = $this->http->get(Config('services.tmdb.link').$endPoint)->json();
        $this->resultKey = $resultKey;
    }

}