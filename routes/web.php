<?php

use App\Http\Controllers\AppealController;
use App\Http\Controllers\NewsController;
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

Route::get('/appeal', [AppealController::class, 'create'])->name('appeal');

Route::post('/appeal/save', [AppealController::class, 'save'])->name('save_appeal');
