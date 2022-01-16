<?php

use App\Http\Controllers\AppealController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\WebAuthController;
use App\Http\Middleware\SuggestAppeal;
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

Route::get('/news', [NewsController::class, 'getList'])->name('news_list');

Route::get('/news/{slug}', [NewsController::class, 'getDetails'])->name('news_item');

Route::get('/appeal', [AppealController::class, 'create'])->name('appeal')
    ->withoutMiddleware([SuggestAppeal::class]);

Route::post('/appeal/save', [AppealController::class, 'save'])->name('save_appeal')
    ->withoutMiddleware([SuggestAppeal::class]);

Route::match(['GET', 'POST'], '/login', [WebAuthController::class, 'login'])->name('login');

Route::match(['GET', 'POST'], '/register', [WebAuthController::class, 'register'])->name('register');

Route::get('/logout', [WebAuthController::class, 'logout'])->name('logout')
    ->middleware('auth:sanctum');

Route::get('/profile', [WebAuthController::class, 'profile'])->name('profile')
    ->middleware('auth:sanctum');
