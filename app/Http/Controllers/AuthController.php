<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponseBuilderTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    use ApiResponseBuilderTrait;
    public function login(Request $request)
    {
        $validator =  $request->apiValidate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $validator->validated();
        if (!$token = auth()->attempt($credentials)) {
            return $this->response('Unauthorized', [], 401);
        }
        return $this->response('login', $this->respondWithToken($token));
    }
    public function register(Request $request)
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

        $token = auth()->login($user);
        return $this->response('registered', $this->respondWithToken($token), 200);
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
