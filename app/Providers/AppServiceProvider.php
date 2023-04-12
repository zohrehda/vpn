<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app
            ->when(\Tymon\JWTAuth\Providers\Storage\Illuminate::class)
            ->needs(\Illuminate\Contracts\Cache\Repository::class)
            ->give(function () {
                return  Cache::store('database');
                return cache()->store('database');
            });

        Request::macro('apiValidate', function ($rules) {

            $validator = Validator::make($this->all(), $rules);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            return $validator;
        });
    }
}
