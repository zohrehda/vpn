<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/fd', function () use ($router) {
    return $router->app->version();
});

$router->get('fd', ['middleware' => '', function () use ($router) {
    return $router->app->version();
}]);

$router->group([], function () use ($router) {
    $router->post('/login', ['uses' => 'AuthController@login']);
    $router->post('/register', ['uses' => 'AuthController@register']);
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', ['uses' => 'UserController@index']);
    Route::post('/', ['uses' => 'UserController@store']);
    Route::put('/{user}', ['uses' => 'UserController@update']);
    Route::delete('/{user}', ['uses' => 'UserController@destroy']);
});


Route::group(['prefix' => 'servers'], function () {
    Route::get('/', ['uses' => 'ServerController@index']);
    Route::post('/', ['uses' => 'ServerController@store']);
    Route::put('/{server}', ['uses' => 'ServerController@update']);
    Route::delete('/{server}', ['uses' => 'ServerController@destroy']);
});

Route::group(['prefix' => 'services'], function () {
    Route::get('/', ['uses' => 'ServiceController@index']);
    Route::post('/', ['uses' => 'ServiceController@store']);
    Route::put('/{service}', ['uses' => 'ServiceController@update']);
    Route::delete('/{service}', ['uses' => 'ServiceController@destroy']);
});

Route::group(['prefix' => 'service_user'], function () {
    Route::get('/', ['uses' => 'UserServiceController@index']);
    Route::post('/', ['uses' => 'UserServiceController@store']);
    Route::put('/{userService}', ['uses' => 'UserServiceController@update']);
    Route::delete('/{userService}', ['uses' => 'UserServiceController@destroy']);
});



Route::group(['prefix' => 'connections'], function () {
    Route::get('/', ['uses' => 'ConnectionController@index']);
    Route::post('/', ['uses' => 'ConnectionController@store']);
    Route::put('/{connection}', ['uses' => 'ConnectionController@update']);
    Route::delete('/{connection}', ['uses' => 'ConnectionController@destroy']);
});
