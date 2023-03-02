<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/movies/{slug}', [IndexController::class, 'movie'])->name('movies');
Route::get('/watch/{slug}/{episode}', [IndexController::class, 'watch']);
Route::get('/filter', [IndexController::class, 'filter'])->name('filter');

Route::get('/year/{year}', [IndexController::class, 'year']);
Route::get('/tag/{tag}', [IndexController::class, 'tag']);
Route::get('/search', [IndexController::class, 'search'])->name('search');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Route
Route::resource('category', CategoryController::class);
Route::post('resorting', [CategoryController::class, 'resorting'])->name('resorting');
Route::get('category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

Route::resource('genre', GenreController::class);
Route::get('genre/delete/{id}', [GenreController::class, 'destroy'])->name('genre.destroy');

Route::resource('country', CountryController::class);
Route::get('country/delete/{id}', [CountryController::class, 'destroy'])->name('country.destroy');


Route::resource('episode', EpisodeController::class);
Route::get('select-movie', [EpisodeController::class, 'selectMovie'])->name('select-movie');

Route::resource('movie', MovieController::class);
Route::post('movie/select-year', [MovieController::class, 'selectYear'])->name('select-year');
Route::post('movie/select-season', [MovieController::class, 'selectSeason'])->name('select-season');
Route::get('movie/delete/{id}', [MovieController::class, 'destroy'])->name('movie.destroy');

// Rating
Route::post('/add-rating', [RatingController::class, 'createRating'])->name('add-rating');

Route::get('/create-sitemap', function () {
  return Artisan::call('sitemap:create');
});