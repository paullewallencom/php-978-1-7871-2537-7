<?php

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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers'], function ($app) {
    $app->get('user', 'UserController@index');
    $app->get('user/{id}', 'UserController@get');
    $app->post('user', 'UserController@create');
    $app->put('user/{id}', 'UserController@update');
    $app->delete('user/{id}', 'UserController@delete');
    $app->get('user/{id}/location', 'UserController@getCurrentLocation');
    $app->post('user/{id}/location/latitude/{latitude}/longitude/{longitude}', 'UserController@setCurrentLocation');
});
