<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\PixbayController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/pixbay/photos', [PixbayController::class, 'getImages']);
Route::middleware('auth:api')->post('/photos/store', [PhotosController::class, 'store']);
Route::middleware('auth:api')->post('/photos/remove', [PhotosController::class, 'removeUserPhoto']);
Route::middleware('auth:api')->get('/photos/user', [PhotosController::class, 'getUserPhotos']);
