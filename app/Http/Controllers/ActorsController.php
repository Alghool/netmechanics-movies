<?php

namespace App\Http\Controllers;

use App\ViewModels\ActorsViewModel;
use App\ViewModels\ActorViewModel;
use Illuminate\Http\Request;

class ActorsController extends Controller
{
    public function index($page = 1)
    {
        $tmdb = resolve('tmdb');

        $popularActors = $tmdb->page($page)->popularActors()->getResponse();

        return view('Actors.index', new  ActorsViewModel($popularActors));
    }

    public function show($id)
    {
        $tmdb = resolve('tmdb');
        $actor = $tmdb->with(['external_ids','combined_credits'])->actor($id)->get();


        return view('Actors.show',new ActorViewModel($actor));
    }
}
