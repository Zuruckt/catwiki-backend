<?php


namespace App\Http\Controllers;

use App\Services\CatApiService;
use Illuminate\Support\Arr;

class CatController extends Controller
{
    private CatApiService $service;

    public function __construct()
    {
        $this->service = app(CatApiService::class);
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

    public function getTopBreeds(): array
    {

    }

}
