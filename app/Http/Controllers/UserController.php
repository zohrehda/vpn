<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponseBuilderTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Enums\UserRoleEnum;
use App\Http\Resources\UserResource;

class UserController extends BaseController
{
    use ApiResponseBuilderTrait;

    public function index()
    {
        return   $this->response('data retrived', User::all());
    }

    public function show(User $user)
    {
       
        return   $this->response('data retrived', UserResource::make($user));
    }

    public function store(Request $request)
    {
        $validator =  $request->apiValidate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'email' => 'email',
            'phone_number' => '',
            'role' => new Enum(UserRoleEnum::class),
            'referral_code' => 'required|exists:users,referral_id',
        ]);

        $user = User::create($validator->validated() + [
            'last_seen' => Carbon::now(),
            'referral_id' => random_string()
        ]);

        return   $this->response('user created', $user->refresh());
    }

    public function update(Request $request, $user)
    {
        $validator =  $request->apiValidate([
            'password' => 'min:8',
            'email' => 'email',
            'phone_number' => '',
            'role' => new Enum(UserRoleEnum::class),
        ]);

        $user->update($request->all());
        return   $this->response('user updated', $user);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return   $this->response('user deleted');
    }
}
