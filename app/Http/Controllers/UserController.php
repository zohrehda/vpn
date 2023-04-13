<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponseBuilderTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    use ApiResponseBuilderTrait;

    public function index()
    {
        return   $this->response('data retrived', User::all());
    }

    public function store(Request $request)
    {
        $validator =  $request->apiValidate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'email' => 'email',
            'phone_number' => '',
            'referral_code' => 'nullable|exists:users,referral_id',

        ]);

        $user = User::create($validator->validated() + [
            'last_seen' => Carbon::now(),
            'referral_id' => random_string()
        ]);

        return   $this->response('user created', $user->refresh());
    }

    public function update(Request $request, $user)
    {
        $user->update($request->all());
        return   $this->response('user updated', $user);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return   $this->response('user deleted');
    }
}
