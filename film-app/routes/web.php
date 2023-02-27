<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [IndexController::class, 'index'])->name('homepage');
Route::get('/categories/{slug}', [IndexController::class, 'category'])->name('categories');
Route::get('/countries/{slug}', [IndexController::class, 'country'])->name('countries');
Route::get('/genres/{slug}', [IndexController::class, 'genre'])->name('genres');
Route::get('/episodes', [IndexController::class, 'episode'])->name('episodes');
Route::get('/home', [IndexController::class, 'home'])->name('home');
Route::get('/movies', [IndexController::class, 'movie'])->name('movies');
Route::get('/watch', [IndexController::class, 'watch'])->name('watch');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Route
Route::resource('category', CategoryController::class);
Route::post('resorting', [CategoryController::class, 'resorting'])->name('resorting');

Route::resource('genre', GenreController::class);
Route::resource('country', CountryController::class);
Route::resource('episode', EpisodeController::class);
Route::resource('movie', MovieController::class);