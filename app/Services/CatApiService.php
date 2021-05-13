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

    public function __construct(SearchRepository $repository)
    {
        $this->client = new Client([
            'base_uri' => 'https://api.thecatapi.com/v1/',
            'headers' => [
                'x-api-key' => env('CATAPI_TOKEN')
            ],
        ]);
        $this->repository = $repository;
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

        $data = json_decode($result->getBody(), true)[0] ?? false;
        if(!$data) return [];

        $data['image_url'] = json_decode($this->client->get('images/search?breed_ids=' . $data['id'])->getBody(), true)[0]['url'] ?? null;
        $this->repository->registerSearch(
            $data['name'],
            $data['description'],
            $data['image_url']
        );
        return $data;
    }

    public function getTopBreeds(): Collection
    {
        return $this->repository->getTopBreeds();
    }

    public function getBreedImages($breedId): array
    {
        $result = $this->client->get(
            'images/search',
            [
                'query' => [
                    'limit' => 20,
                    'breed_id' =>$breedId,
                ]
            ]
        );
        return array_column(json_decode($result->getBody(), true), 'url');
    }
}
