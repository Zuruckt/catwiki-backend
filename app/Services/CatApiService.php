<?php
namespace App\Services;

use App\Repositories\SearchRepository;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class CatApiService
{
    private Client $client;
    private SearchRepository $repository;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.thecatapi.com/v1/',
            'headers' => [
                'x-api-key' => env('CATAPI_TOKEN')
            ],
        ]);
        $this->repository = app(SearchRepository::class);
    }

    public function searchBreedsByName(string $name): array
    {
        $result = $this->client->get('breeds/search?q=' . $name);
        $data = json_decode($result->getBody(), true);
        return Arr::pluck($data, 'name');
    }

    public function getBreed(string $name): array
    {
        $result = $this->client->get('breeds/search?q=' . $name);

        $data = json_decode($result->getBody(), true)[0] ?? null;

        if(!$data) return [];

        $this->repository->registerSearch($data['name'], $data['description']);
        return $data;
    }

    public function getTopBreeds(): Collection
    {
        return $this->repository->getTopBreeds();
    }
}
