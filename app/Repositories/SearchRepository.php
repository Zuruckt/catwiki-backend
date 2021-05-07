<?php

namespace App\Repositories;

use App\Models\Search;

class SearchRepository
{
    private Search $model;

    public function __construct()
    {
        $this->model = app(Search::class);
    }

    public function registerSearch(string $breedName, $breedDescription)
    {
        $model = $this->model->where('breed_name', $breedName)->first();

        if($model) {
            $model->update(['count' => $model->count + 1]);
            return true;
        }

        $this->model->create(['breed_name' => $breedName, 'breed_description' => $breedDescription, 'count' => 1]);
        return true;
    }

    public function getTopBreeds()
    {
        return $this->model->orderBy('count')->take(10)->get();

    }
}