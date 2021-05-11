<?php

namespace App\Repositories;

use App\Models\Search;
use Illuminate\Database\Eloquent\Collection;

class SearchRepository
{
    private Search $model;

    public function __construct(Search $model)
    {
        $this->model = $model;
    }

    public function registerSearch(string $breedName, $breedDescription, $breedPhotoUrl): bool
    {
        $model = $this->model->where('breed_name', $breedName)->first();

        if($model) {
            $model->update(['count' => $model->count + 1]);
            return true;
        }

        $this->model->create([
            'breed_name' => $breedName,
            'breed_description' => $breedDescription,
            'breed_photo_url' => $breedPhotoUrl,
            'count' => 1
        ]);
        return true;
    }

    public function getTopBreeds(): Collection
    {
        return $this->model->orderBy('count', 'desc')->take(10)->get();
    }
}