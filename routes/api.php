<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware'=>'guest'], function (){
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('profile', [\App\Http\Controllers\UserController::class, 'profile']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    // todo: test out
    Route::get('preferences', [\App\Http\Controllers\PreferenceController::class, 'show']);
    Route::post('preferences', [\App\Http\Controllers\PreferenceController::class, 'store']);

});

Route::get('sources', [\App\Http\Controllers\SourceController::class, 'index']);
Route::get('news', [\App\Http\Controllers\NewsController::class, 'index']);
