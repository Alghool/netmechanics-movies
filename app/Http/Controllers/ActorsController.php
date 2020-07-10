<?php

namespace App\Http\Controllers;

use App\ViewModels\ActorsViewModel;
use Illuminate\Http\Request;

class ActorsController extends Controller
{
    public function index()
    {
        $tmdb = resolve('tmdb');

        $popularActors = $tmdb->popularActors()->getResponse();

        return view('Actors.index', new  ActorsViewModel($popularActors));
    }

    public function show($id)
    {

//        return view('Actors.index');
    }
}
