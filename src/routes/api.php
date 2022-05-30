<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

JsonApiRoute::server('v1')->prefix('v1')->resources(function ($server) {
   $server->resource('posts', JsonApiController::class)->relationships(function ($relations){
       $relations->hasOne('user')->readOnly();
       $relations->hasOne('category')->readOnly();
       $relations->hasMany('comments')->readOnly();
   });
   $server->resource('categories', JsonApiController::class);
   $server->resource('users', JsonApiController::class);
   $server->resource('comments', JsonApiController::class);
   $server->resource('books', JsonApiController::class);
   $server->resource('authors', JsonApiController::class);
});
