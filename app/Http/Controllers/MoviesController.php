<?php

namespace App\Http\Controllers;

use App\servers\Tmdb;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{

    public function index()
    {
        $tmdb = resolve('tmdb');
        $popularMovies = $tmdb->popularMovies()->getResult();
        dump($popularMovies);

        $popularMovies2 = $tmdb->popularMovies()->getResponse();
        dd($popularMovies2);

        $genresArray = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.link'). 'genre/movie/list')
            ->json();

        $genres = collect($genresArray['genres'])->mapWithKeys(function($genre){
            return [$genre['id'] => $genre['name']];
        });

        dd($genres);

        return view('movies.index',[
            'popularMovies' => $popularMovies
        ]);
        //
    }

    public function show($id)
    {
        //
    }

}
