<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $listCategories = Category::orderBy('id', 'DESC')->where('status', '1')->get();
        $listGenres = Genre::orderBy('id', 'DESC')->where('status', '1')->get();
        $listCountries = Country::orderBy('id', 'DESC')->where('status', '1')->get();

        $listCategoryByMovie = Category::with('movies')->orderBy('id', 'ASC')->where('status', '1')->take(12)->get();
        // echo '<pre>';
        // print_r($listCategoryByMovie);
        // echo '</pre>';
        return view('pages.home', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listCategoryByMovie',
        ));
    }
    public function category($slug)
    {
        $listCategories = Category::orderBy('id', 'DESC')->get();
        $listGenres = Genre::orderBy('id', 'DESC')->get();
        $listCountries = Country::orderBy('id', 'DESC')->get();

        $listCategoryBySlug = Category::where('slug', $slug)->first();

        return view('pages.category', compact('listCategories', 'listGenres', 'listCountries', 'listCategoryBySlug'));
    }
    public function country($slug)
    {
        $listCategories = Category::orderBy('id', 'DESC')->get();
        $listGenres = Genre::orderBy('id', 'DESC')->get();
        $listCountries = Country::orderBy('id', 'DESC')->get();

        $listCountryBySlug = Country::where('slug', $slug)->first();

        return view('pages.country', compact('listCategories', 'listGenres', 'listCountries', 'listCountryBySlug'));
    }
    public function genre($slug)
    {
        $listCategories = Category::orderBy('id', 'DESC')->get();
        $listGenres = Genre::orderBy('id', 'DESC')->get();
        $listCountries = Country::orderBy('id', 'DESC')->get();

        $listGenreBySlug = Genre::where('slug', $slug)->first();

        return view('pages.genre', compact('listCategories', 'listGenres', 'listCountries', 'listGenreBySlug'));
    }
    public function episode()
    {
        return view('pages.episode');
    }

    public function watch()
    {
        return view('pages.watch');
    }
    public function movie()
    {
        return view('pages.movie');
    }
}