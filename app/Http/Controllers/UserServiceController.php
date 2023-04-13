<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use App\Models\UserService;
use App\Traits\ApiResponseBuilderTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
use PDO;

class UserServiceController extends BaseController
{
    use ApiResponseBuilderTrait;

    public function index()
    {
        return $this->response('data retrived', UserService::all());
    }

    public function store(Request $request)
    {
        $validator =  $request->apiValidate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        $user = User::find($request->input('user_id'));
        if ($user->services()->wherePivot('end_date', '>', Carbon::now())->count() > 0) {
            return   $this->response('there is a active service for this user');
        }

        $server =  DB::transaction(function () use ($validator, $user) {
            if ($user->referral_code) {
                User::where('referral_id', $user->referral_code)->first()->increment('referrals');
            }
            return UserService::create($validator->validated());
        });

        return  $this->response('service added for user', $server->refresh());
    }

    public function update(Request $request, UserService $userService)
    {
        $validator =  $request->apiValidate([
            'start_date' => 'date',
            'end_date' => 'date',
        ]);
        $userService->update($validator->validated());
        return   $this->response('userService updated', $userService);
    }

    public function destroy(Request $request, UserService $userService)
    {
        $userService->delete();
        return   $this->response('userService deleted');
    }
}
