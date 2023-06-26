<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ArtistController;
use App\Http\Controllers\API\AlbumController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* 
Route::get('/', function () {
    return view('welcome');
});
 */

// Auth::routes();
Auth::routes(['register' => false]);
Route::post('/user/login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout']);

//override the default 
/* Route::get('/', function () {
    return view('layouts.app');
}); */

Route::get('authorize/google', [LoginController::class, 'redirectToGoogle']);
Route::get('authorized/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*');
