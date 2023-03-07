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

Route::get('/loai-phim/{slug}', [IndexController::class, 'category'])->name('loai-phim');
Route::get('/quoc-gia/{slug}', [IndexController::class, 'country'])->name('quoc-gia');
Route::get('/the-loai/{slug}', [IndexController::class, 'genre'])->name('the-loai');

Route::get('/episodes', [IndexController::class, 'episode'])->name('episodes');
Route::get('/home', [IndexController::class, 'home'])->name('home');
Route::get('/phim/{slug}', [IndexController::class, 'movie'])->name('phim');
Route::get('/xem-phim/{slug}/{episode}', [IndexController::class, 'watch']);
Route::get('/filter', [IndexController::class, 'filter'])->name('filter');

Route::get('/nam/{year}', [IndexController::class, 'year'])->name('name');
Route::get('/tag/{tag}', [IndexController::class, 'tag']);
Route::get('/search', [IndexController::class, 'search'])->name('search');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Route
Route::resource('category', CategoryController::class);
Route::post('resorting', [CategoryController::class, 'resorting'])->name('resorting');
Route::post('category_status', [CategoryController::class, 'categoryStatus'])->name('category_status');
Route::get('category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

Route::resource('genre', GenreController::class);
Route::post('genre_status', [GenreController::class, 'genreStatus'])->name('genre_status');
Route::get('genre/delete/{id}', [GenreController::class, 'destroy'])->name('genre.destroy');

Route::resource('country', CountryController::class);
Route::post('country_status', [CountryController::class, 'countryStatus'])->name('country_status');
Route::get('country/delete/{id}', [CountryController::class, 'destroy'])->name('country.destroy');


Route::resource('episode', EpisodeController::class);
Route::get('select-movie', [EpisodeController::class, 'selectMovie'])->name('select-movie');

Route::resource('movie', MovieController::class);
Route::post('movie/select-year', [MovieController::class, 'selectYear'])->name('select-year');
Route::post('movie/select-season', [MovieController::class, 'selectSeason'])->name('select-season');
Route::post('movie/select-top-view', [MovieController::class, 'selectTopView'])->name('select-top-view');
Route::post('movie/category-choose', [MovieController::class, 'categoryChoose'])->name('category-choose');
Route::post('movie/country-choose', [MovieController::class, 'countryChoose'])->name('country-choose');
Route::post('movie/status-choose', [MovieController::class, 'statusChoose'])->name('status-choose');
Route::post('movie/resolution-choose', [MovieController::class, 'resolutionChoose'])->name('resolution-choose');
Route::post('movie/hot-choose', [MovieController::class, 'hotChoose'])->name('hot-choose');
Route::post('movie/subtitle-choose', [MovieController::class, 'subtitleChoose'])->name('subtitle-choose');
Route::post('movie/belong-movie-choose', [MovieController::class, 'belongMovieChoose'])->name('belong-movie-choose');
Route::post('filter-top-view', [MovieController::class, 'filterTopView'])->name('filter-top-view');
Route::post('filter-top-view-default', [MovieController::class, 'filterTopViewDefault'])->name('filter-top-view-default');

Route::get('/json/run', [MovieController::class, 'runJson'])->name('json');

Route::get('movie/delete/{id}', [MovieController::class, 'destroy'])->name('movie.destroy');

// Rating
Route::post('/add-rating', [RatingController::class, 'createRating'])->name('add-rating');

Route::get('/create-sitemap', function () {
  return Artisan::call('sitemap:create');
});