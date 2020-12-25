<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['method' => 'index']);
    }

    public function get($id)
    {
        return response()->json(['method' => 'get', 'id' => $id]);
    }

    public function create(Request $request)
    {
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
