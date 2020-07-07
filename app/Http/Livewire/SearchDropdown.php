<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = [];
        if(strlen($this->search) >= 2){
            $tmdb = resolve('tmdb');
            $searchResults = $tmdb->searchMovies($this->search)->get()->take(5);
        }
        return view('livewire.search-dropdown',['searchResults' => $searchResults]);
    }
}
