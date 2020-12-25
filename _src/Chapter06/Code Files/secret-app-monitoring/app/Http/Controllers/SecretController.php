<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Secret;
use App\Transformers\SecretTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Datadogstatsd;

class SecretController extends Controller
{
    const APM_API_KEY = 'api-key-from-your-acccount';
    const APM_APP_KEY = 'app-key-from-your-account';

    protected static $secretValidationRules = [
        'name'          => 'required|string|unique:secrets.name',
        'latitude'      => 'required|numeric',
        'longitude'     => 'required|numeric',
        'location_name' => 'required|string'
    ];

    public function index(Manager $fractal, SecretTransformer $secretTransformer, Request $request)
    {
        Datadogstatsd::configure(self::APM_API_KEY, self::APM_APP_KEY);
        $startTime = microtime(true);

        $records = Secret::all();

        $collection = new Collection($records, $secretTransformer);

        $data = $fractal->createData($collection)->toArray();

        Datadogstatsd::timing('secrets.loading.time', microtime(true) - $startTime);

        return response()->json($data);
    }

    public function get($id)
    {
        return response()->json(['method' => 'get', 'id' => $id]);
    }

    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'          => 'required|string|unique:secrets,name',
                'latitude'      => 'required|numeric',
                'longitude'     => 'required|numeric',
                'location_name' => 'required|string'
            ]
        );

        $secret = Secret::create($request->all());

        if ($secret->save() === false) {
            // Manage error
        }

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
}
