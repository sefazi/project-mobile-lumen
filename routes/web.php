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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Data Barang
$router->group(['prefix' => 'items'], function () use ($router) {
    // Create a new item (GET and POST)
    // $router->get('create', 'Item@create');
    $router->post('store', 'Item@create');

    // Show a specific item
    $router->get('{id}', 'Item@show');

    // Edit an item (GET and POST)
    // $router->get('{item}/edit', 'Item@edit');
    $router->put('{id}', 'Item@update');
    $router->put('rating/{id}', 'Item@updateRating');

    // Delete an item
    $router->delete('{id}', 'Item@destroy');

    // List all items
    $router->get('/', 'Item@index');
});

// Data Users
$router->group(['prefix' => 'users'], function () use ($router) {
    // List all users
    $router->get('/', 'UsersController@index');

    // Create a new user
    $router->post('/', 'UsersController@store');

    // Show a specific user
    $router->get('{id}', 'UsersController@show');

    // Update a user
    $router->put('{id}', 'UsersController@update');

    // Delete a user
    $router->delete('{id}', 'UsersController@destroy');

    // Check Account
    $router->post('check', 'UsersController@check');
});

$router->group(['prefix' => 'rating'], function () use ($router) {
    // Get rating by id post
    $router->get('{id}', 'RatingController@show');

    // Insert Rating
    $router->post('/', 'RatingController@store');
});
