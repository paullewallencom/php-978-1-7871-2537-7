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
    $app->get('battle', 'BattleController@index');
    $app->get('battle/{id}', 'BattleController@get');
    $app->post('battle', 'BattleController@create');
    $app->put('battle/{id}', 'BattleController@update');
    $app->delete('battle/{id}', 'BattleController@delete');
});
