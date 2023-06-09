<?php

namespace App\Http\Middleware;

use App\Models\Token;
use App\Traits\ApiResponseBuilderTrait;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    use ApiResponseBuilderTrait;
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null, $guard = null)
    {
        $access = [
            'user' => ['creator', 'admin', 'user'],
            'admin' => ['creator', 'admin',],
            'creator' => ['creator']
        ];
        //if ($role and auth()->user() and auth()->user()->role !== $role)
        $user_role = auth()->user()->role;
        if ($role and auth()->user() and !in_array($user_role, $access[$role])) {
            return $this->response('Unauthorized', [], 403);
        }

        if ($this->auth->guard($guard)->guest()) {
            return $this->response('Unauthorized', [], 401);
        }

        Token::firstOrCreate([
            'user_id' => auth()->user()->id,
            'value' => $request->bearerToken()
        ]);

        return $next($request);
    }
}
