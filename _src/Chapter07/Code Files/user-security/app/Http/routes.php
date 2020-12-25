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

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

$app->post('login', function(Request $request, JWTAuth $jwt) {
    $this->validate($request, [
        'email' => 'required|email|exists:users',
        'password' => 'required|string'
    ]);
    if (! $token = $jwt->attempt($request->only(['email', 'password']))) {
        return response()->json(['user_not_found'], 404);
    }
    return response()->json(compact('token'));
});

$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->post('user', function (JWTAuth $jwt) {
        $user = $jwt->parseToken()->toUser();
        return $user;
    });
});