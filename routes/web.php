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

$router->group(['middleware' => ''], function () use ($router) {
});

$router->get('/users', ['uses' => 'UserController@index']);


$router->group(['prefix' => 'servers'], function () use ($router) {
    // $router->get('/', ['uses' => 'ServerController@index']);
    //    $router->put('/{server}', ['uses' => 'ServerController@update']);
    //   $router->delete('/{server}', ['uses' => 'ServerController@destroy']);
    //  $router->post('/', ['uses' => 'ServerController@store']);
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




// $router->group(function() use($router){
//     // $router->post('/device') ;
//     // $router->post('/login',[]) ;
//     // $router->post('/register') ;
//     // $router->get('/users') ;
    
// }) ;

// post 
