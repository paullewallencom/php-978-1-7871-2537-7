<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use App\Jobs\GiftJob;
use Illuminate\Support\Facades\Gate;
use App\Model\User;

use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserController extends Controller
{
    protected $userCache = [
        1 => [
            'name' => 'John',
            'city' => 'Barcelona'
        ],
        2 => [
            'name' => 'Joe',
            'city' => 'Paris'
        ]
    ];


    public function index()
    {
        return response()->json(['method' => 'index']);
    }

    public function get($id)
    {
        return response()->json(['method' => 'get', 'id' => $id]);
    }

    public function getWallet($id)
    {
        /* ... Code ommited ... */

        $client = new Client(['verify' => false]);

        try {
            $remoteCall = $client->get('http://microservice_secretz_nginx/api/v1/secret/1');
        } catch (ConnectException $e) {
            /* ... Code ommited ... */
            throw $e;
        } catch (ServerException $e) {
            /* ... Code ommited ... */
        } catch (\Exception $e) {
            /* ... Code ommited ... */
        }

        /* ... Code omitted ... */
    }

    public function create(Request $request)
    {
        /* ... Code omitted (validate & save data) ... */

        $this->dispatch(new GiftJob());

        /* ... Code omitted ... */
        return response()->json(['method' => 'create']);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['method' => 'update', 'id' => $id]);
    }

    public function delete($id)
    {
        return response()->json(['method' => 'delete', 'id' => $id]);
    }

    public function getCurrentLocation($id)
    {
        return response()->json(['method' => 'getCurrentLocation', 'id' => $id]);
    }

    public function setCurrentLocation(Request $request, $id, $latitude, $longitude)
    {
        return response()->json(['method' => 'setCurrentLocation', 'id' => $id, 'latitude' => $latitude, 'longitude' => $longitude]);
    }
}
