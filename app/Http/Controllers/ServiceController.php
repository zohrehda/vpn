<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Traits\ApiResponseBuilderTrait;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ServiceController extends BaseController
{
    use ApiResponseBuilderTrait;

    public function index()
    {
        return  $this->response('services retrived', Service::all());
    }

    public function store(Request $request)
    {
        $validator =  $request->apiValidate([
            'name' => 'required',
            'price' => 'required|integer',
            'description' => 'required',
            'accounts_limit' => 'required|integer',
            'traffic' => 'nullable',
            'duration' => 'required|integer'
        ]);

        $service = Service::create($validator->validated());

        return   $this->response('service created', $service->refresh());
    }

    public function update(Request $request, Service $service)
    {
        $validator =  $request->apiValidate([
            'name' => '',
            'price' => 'integer',
            'description' => '',
            'accounts_limit' => 'integer'

        ]);
        $service->update($request->all());
        return   $this->response('service updated', $service);
    }

    public function destroy(Request $request, Service $service)
    {
        $service->delete();
        return   $this->response('service deleted');
    }
}
