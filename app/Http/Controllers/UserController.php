<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponseBuilderTrait;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    use ApiResponseBuilderTrait;

    public function index()
    {
        return   $this->response('data retrived', User::all());
    }
}
