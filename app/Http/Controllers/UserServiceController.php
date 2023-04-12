<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Traits\ApiResponseBuilderTrait;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserServiceController extends BaseController
{
    use ApiResponseBuilderTrait;

    public function index()
    {
        return   $this->response('data retrived', Service::all());
    }

    public function store(Request $request)
    {
        $validator =  $request->apiValidate([
            'user_id' => 'required|exists:users',
            'service_id' => 'required|exists:services',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $server = Service::create($validator->validated());

        return   $this->response('service created', $server->refresh());
    }

    public function update(Request $request, Service $service)
    {
        $validator =  $request->apiValidate([
            //'name' => 'required',
            'price' => 'integer',
        ]);
        $service->update($request->all());
        return   $this->response('service updated', $service);
    }

    public function destroy(Request $request, Service $service)
    {
        $service->delete();
        return   $this->response('server deleted');
    }
}