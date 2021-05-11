<?php


namespace App\Http\Controllers;

use App\Services\CatApiService;

class CatController extends Controller
{
    private CatApiService $service;

    public function __construct(CatApiService $service)
    {
        $this->service = $service;    
    }

    public function searchBreedsByName(string $name)
    {
        return $this->service->searchBreedsByName($name);
    }

    public function getBreed(string $name)
    {
        $breed = $this->service->getBreed($name);
        if(!$breed) return response(['error' => 'Breed not found'], 404);
        return $breed;
    }

    public function getTopBreeds()
    {
        return $this->service->getTopBreeds();
    }

    public function getBreedImages($breedId)
    {
        return $this->service->getBreedImages($breedId);
    }

}
