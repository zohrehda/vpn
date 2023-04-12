<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\User;
use App\Traits\ApiResponseBuilderTrait;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ServerController extends BaseController
{
    use ApiResponseBuilderTrait;

    public function index()
    {
        return   $this->response('data retrived', Server::all());
    }

    public function store(Request $request)
    {
        $validator =  $request->apiValidate([
            'name' => 'required',
            'ip' => 'required',
            'port' => 'required',
            'connection_method' => 'required'

        ]);
        $server = Server::create($validator->validated());

        return   $this->response('server created', $server->refresh());
    }

    public function update(Request $request, $server)
    {
        $server->update($request->all());
        return   $this->response('server updated', $server);
    }

    public function destroy(Request $request, Server $server)
    {
        $server->delete();
        return   $this->response('server deleted');
    }
}
