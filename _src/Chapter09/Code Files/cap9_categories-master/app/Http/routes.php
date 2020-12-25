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

$app->post('category', 'CategoryController@createCategory');
$app->put('category/{id}', 'CategoryController@updateCategory');
$app->delete('category/{id}', 'CategoryController@deleteCategory');
$app->get('categories', 'CategoryController@getCategories');
$app->get('category/{id}', 'CategoryController@getCategory');

