<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::group(['prefix' => 'auth'], function () {
    Route::post('login',  [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('posts',  [PostController::class, 'index']);
    Route::group(['prefix' => '/api/post'], function () {
        Route::post('add',  [PostController::class, 'add']);
        Route::get('edit/{id}', [PostController::class, 'edit']);
        Route::post('update/{id}', [PostController::class, 'update']);
        Route::delete('delete/{id}', [PostController::class, 'delete']);
    });
    
    Route::get('/albums/search/{name}/artist/{artist}', [AlbumController::class, 'search']);
    Route::get('/artists/search/{name}', [ArtistController::class, 'search']);
    Route::apiResources([
        'artists' => ArtistController::class,
        'albums' => AlbumController::class,
    ]);
});
