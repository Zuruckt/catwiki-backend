<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['middleware' => 'cors'], function() use ($router) {
    $router->get('breeds/top', 'CatController@getTopBreeds');
    $router->get('breeds/{name}', 'CatController@searchBreedsByName');
    $router->get('breed/{name}', 'CatController@getBreed');
    $router->get('breed/{breedId}/images', 'CatController@getBreedImages');
});


