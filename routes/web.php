<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => L5Swagger\Http\Middleware\Config::class, 'l5-swagger.documentation' => 'default'
], function () {
    Route::get('api/docs/{apiType?}', [
        'as'   => 'l5-swagger.default.api.api_type',
        'uses' => 'App\Http\Controllers\SwaggerController@api',
    ]);

    Route::get('docs/{folder?}/{jsonFile?}', [
        'as'   => 'l5-swagger.default.docs.subfolder_file',
        'uses' => 'App\Http\Controllers\SwaggerController@docs',
    ]);
});
