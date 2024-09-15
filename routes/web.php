<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('articles')
    ->name('articles.')
    ->controller(ArticleController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/createEdit', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::post('/{id}/destroy', 'destroy')->name('destroy');
    });

// コメント
Route::prefix('comments')
    ->name('comments.')
    ->controller(CommentController::class)
    ->group(function () {
        // Route::get('/', 'index')->name('index');
        Route::post('/{id}', 'store')->name('store');
        // Route::get('/{id}', 'show')->name('show');
        // Route::get('/{id}/edit', 'edit')->name('edit');
        Route::post('/{id}/destroy', 'destroy')->name('destroy');
    });
