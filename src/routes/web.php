<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewsController;

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

Route::group(['prefix' => 'login'], function() {
    Route::get('/', [LoginController::class, 'show'])->name('show');
    Route::post('/', [LoginController::class, 'login'])->name('login');    
});

Route::group(['prefix' => 'news'], function() {
    Route::get('/{news}/show', [NewsController::class, 'show'])->name('news.show');
});