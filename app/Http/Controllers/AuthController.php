<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserDevice;
use App\Traits\ApiResponseBuilderTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        $user = User::where('username', $request->input('username'))->first();

        if ($user->currentService() and $user->tokens->count() === $user->currentService()->accounts_limit) {
            return $this->response('too many account', [], 401);
        }

        if ($request->anyFilled(['device_id', 'platform', 'device_name', 'physical'])) {
            UserDevice::firstOrCreate([
                'user_id' => $user->id,
                'device_id' => $request->input('device_id'),
                'platform' => $request->input('platform'),
                'device_name' => $request->input('device_name'),
                'physical' => $request->input('physical'),
            ]);
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
            'referral_code' => 'required|exists:users,referral_id',

        ]);
        $user = User::create($validator->validated());

        $token = auth()->login($user);
        return $this->response('registered', $this->respondWithToken($token), 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->where('value', $request->bearerToken())->delete();
        auth()->logout();
        return $this->response('user logout');
    }

    public function show()
    {
        return  $this->response('data retrived', UserResource::make(auth()->user()));
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
