<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    public function index()
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->where('status', 1)->get();

        $listCategoryByMovie = Category::with('movies')->orderBy('created_at', 'ASC')->where('status', 1)->take(12)->get();
        $listHotMovies = Movie::orderBy('created_at', 'ASC')->where('status', 1)->where('movie_hot', 1)->get();
        $listTrailerMovies = Movie::orderBy('created_at', 'ASC')->where('status', 1)->where('resolution', 5)->get();

        return view('pages.home', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listCategoryByMovie',
            'listHotMovies',
            'listTrailerMovies'
        ));
    }
    public function category($slug)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->get();

        $listCategoryBySlug = Category::where('slug', $slug)->first();

        $listMovieBySlug = Movie::where('category_id', $listCategoryBySlug->created_at)->paginate(10);

        return view('pages.category', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listCategoryBySlug',
            'listMovieBySlug'
        ));
    }
    public function country($slug)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->get();

        $listCountryBySlug = Country::where('slug', $slug)->first();

        $listMovieBySlug = Movie::where('country_id', $listCountryBySlug->created_at)->paginate(40);

        return view('pages.country', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listCountryBySlug',
            'listMovieBySlug'
        ));
    }
    public function genre($slug)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->get();

        $listGenreBySlug = Genre::where('slug', $slug)->first();


        // List movies genres
        $listMovieGenres = MovieGenre::where('genre_id', $listGenreBySlug->id)->get();
        $manyGenre = [];
        foreach ($listMovieGenres as $key => $value) {
            $manyGenre[] = $value->movie_id;
        }

        $listMovieBySlug = Movie::whereIn('id', $manyGenre)->orderBy('created_at', 'DESC')->paginate(20);

        return view('pages.genre', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listGenreBySlug',
            'listMovieBySlug',
        ));
    }
    public function episode()
    {
        return view('pages.episode');
    }

    public function watch($slug)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->where('status', 1)->get();

        $listMovieBySlug = Movie::with('category', 'genre', 'country', 'movieGenre')->where('slug', $slug)->where('status', 1)->first();

        return view('pages.watch', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listMovieBySlug',
        ));
    }
    public function movie($slug)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->where('status', 1)->get();

        $listMovieBySlug = Movie::with('category', 'genre', 'country', 'movieGenre')->where('slug', $slug)->where('status', 1)->first();

        $listMovieRelate = Movie::with('category', 'genre', 'country')
            ->where('category_id', $listMovieBySlug->category->created_at)
            ->where('status', 1)
            ->whereNotIn('slug', [$slug])
            ->orderBy(DB::raw('RAND()'))
            ->get();

        return view('pages.movie', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listMovieBySlug',
            'listMovieRelate'
        ));
    }

    public function year($year)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->get();

        $listMovieByYear = Movie::where('year', $year)->paginate(20);

        return view('pages.year', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listMovieByYear',
            'year'
        ));
    }

    public function tag($tag)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->get();

        $listMovieByTag = Movie::where('tags', 'LIKE', '%' . $tag . '%')->paginate(20);

        return view('pages.tag', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listMovieByTag',
            'tag'
        ));
    }

    public function search()
    {
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $listCategories = Category::orderBy('created_at', 'DESC')->get();
            $listGenres = Genre::orderBy('created_at', 'DESC')->get();
            $listCountries = Country::orderBy('created_at', 'DESC')->get();

            $listMovieBySearch = Movie::where('title', 'LIKE', '%' . $search . '%')->paginate(10);
            $listHotMovies = Movie::orderBy('created_at', 'ASC')->where('status', 1)->where('movie_hot', 1)->get();
            $listTrailerMovies = Movie::orderBy('created_at', 'ASC')->where('status', 1)->where('resolution', 5)->get();

            return view('pages.search', compact(
                'listCategories',
                'listGenres',
                'listCountries',
                'listMovieBySearch',
                'search'
            ));
        } else {
            return redirect()->to('/');
        }
    }
}