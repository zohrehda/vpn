<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponseBuilderTrait;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    use ApiResponseBuilderTrait;
    public function login()
    {
        //    dd('ff');
    }
    public function register(Request $request)
    {
        $validator =  $request->apiValidate([
            'username' => 'required|unique:users,username',
            'email' => 'email',
            'phone_number' => '',
            'referral_code' => 'exists:users,referral_id',
        ]);
        $user = User::create($validator->validated() + []);
        if ($request->filled('referral_code')) {
            User::where('referral_id', 'referral_code')->first()->increment('referrals');
            
        }
        $token = auth()->login($user);
        return $this->response('registered', $token, 200);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
