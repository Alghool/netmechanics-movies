<?php

namespace App\Http\Controllers;

use App\ViewModels\TvShowViewModel;
use App\ViewModels\TvViewModel;
use Illuminate\Http\Request;

class TvController extends Controller
{

    public function index(){
        $tmdb = resolve('tmdb');
        $popularTv = $tmdb->popularTv()->get();
        $topRatedTv = $tmdb->topRatedTv()->get();
        $genres = $tmdb->tvGenre()->get();

        $tvViewModel = new TvViewModel(
            $popularTv,
            $topRatedTv,
            $genres
        );

        return view('tv.index',$tvViewModel);

    }

    public function show($id){
        $tmdb = resolve('tmdb');
        $tv = $tmdb->with(['videos','credits','images'])->tv($id)->get();

        return view('tv.show',new TvShowViewModel($tv));
    }
}
