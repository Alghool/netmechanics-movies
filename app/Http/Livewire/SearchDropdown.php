<?php

namespace App\Http\Livewire;

use App\ViewModels\SearchViewModel;
use Livewire\Component;

class SearchDropdown extends Component
{
    public $search = '';

    public function render()
    {
        $searchResults = collect();
        if(strlen($this->search) >= 2){
            $tmdb = resolve('tmdb');
            $searchResults = $tmdb->search($this->search)->get()->take(5);
        }
        return view('livewire.search-dropdown',new SearchViewModel($searchResults));
    }
}
