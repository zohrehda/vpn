<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use App\Traits\ApiResponseBuilderTrait;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ConnectionController extends BaseController
{
    use ApiResponseBuilderTrait;

    public function index()
    {
        return   $this->response('data retrived', Connection::all());
    }

    public function store(Request $request)
    {
        $validator =  $request->apiValidate([
            'user_id' => 'required|exists:users,id',
            'server_id' => 'required|exists:servers,id',
            'isp' => '',
        ]);
        $connection = Connection::create($validator->validated());

        return   $this->response('connection created', $connection->refresh());
    }


    public function destroy(Request $request, Connection $connection)
    {
        $connection->delete();
        return   $this->response('connection deleted');
    }
}
