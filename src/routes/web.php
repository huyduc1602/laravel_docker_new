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
Route::get('/welcome', function () {return view('welcome');})->name('welcome');

Route::group(['prefix' => 'login'], function() {
    Route::get('/', [LoginController::class, 'show'])->name('show');
    Route::post('/', [LoginController::class, 'login'])->name('login');
});

Route::group(['prefix' => 'news'], function() {
        Route::get('/', [NewsController::class, 'index'])->name('news'); //OK
        Route::get('/list', [NewsController::class, 'getRecords'])->name('news.list'); //OK
        Route::post('/create', [NewsController::class, 'create'])->name('news.create'); //OK
        Route::get('/{news}/show', [NewsController::class, 'show'])->name('news.show'); //OK
        Route::patch('/{news}', [NewsController::class, 'update'])->name('news.update'); //OK
        Route::delete('/{news}', [NewsController::class, 'delete'])->name('news.delete'); //OK
        Route::get('/search', [NewsController::class, 'search'])->name('news.search'); //OK
    });

Route::get('/news', function () {return view('news');})->name('news');