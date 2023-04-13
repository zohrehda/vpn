<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;

class UserLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (auth()->check()) {
            User::where('id', auth()->user()->id)->update(['last_seen' => Carbon::now()]);
        }
        return $next($request);
    }
}
