<?php

use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthenticatedSessionController as UserAuthenticatedSessionController;


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

/**
 * User API Routes
 */
Route::group(['middleware' => ['api', 'locale'], 'prefix' => 'user'], static function () {
    Route::group(['prefix' => 'auth'], static function () {
        Route::post('login', [UserAuthenticatedSessionController::class, 'store']);
        Route::post('register', [UserAuthenticatedSessionController::class, 'register']);
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store']);
    });

    Route::group(['middleware' => 'auth:api'], static function () {
        Route::post('me', [UserAuthenticatedSessionController::class, 'me']);
        Route::post('logout', [UserAuthenticatedSessionController::class, 'destroy']);
    });

    Route::group(['middleware' => 'user_authentication'], static function () {
        Route::get('me', [UserController::class, 'edit']);
        Route::put('me', [UserController::class, 'update']);
    });
});
