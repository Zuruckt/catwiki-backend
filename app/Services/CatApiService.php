<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class CatApiService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.thecatapi.com/v1/',
            'headers' => [
                'x-api-key' => env('CATAPI_TOKEN')
            ],
        ]);
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
        return json_decode($result->getBody(), true)[0] ?? [];
    }
}
