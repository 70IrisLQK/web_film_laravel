<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieGenre;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends Controller
{

    public function index()
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->where('status', 1)->get();

        $listCategoryByMovie = Category::with([
            'movies' => function ($q) {
                $q->withCount('episodes');
            }
        ])->orderBy('created_at', 'ASC')->where('status', 1)->get();

        $listHotMovies = Movie::withCount('episodes')
            ->orderBy('created_at', 'DESC')
            ->where('status', 1)
            ->where('movie_hot', 1)
            ->take(12)
            ->get();

        $listTrailerMovies = Movie::orderBy('created_at', 'ASC')
            ->where('status_movie', 2)
            ->get();

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
        $listMovieBySlug = Movie::with('category')
            ->withCount('episodes')
            ->where('category_id', $listCategoryBySlug->id)
            ->paginate(12);

        $listHotMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status', 1)->where('movie_hot', 1)->get();
        $listTrailerMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status_movie', 2)->get();



        return view('pages.category', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listCategoryBySlug',
            'listMovieBySlug',
            'listHotMovies',
            'listTrailerMovies'
        ));
    }
    public function country($slug)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->get();

        $listCountryBySlug = Country::where('slug', $slug)->first();

        $listMovieBySlug = Movie::with('category')->withCount('episodes')->where('country_id', $listCountryBySlug->id)->paginate(12);
        $listHotMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status', 1)->where('movie_hot', 1)->get();
        $listTrailerMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status_movie', 2)->get();

        return view('pages.country', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listCountryBySlug',
            'listMovieBySlug',
            'listTrailerMovies',
            'listHotMovies'
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

        $listMovieBySlug = Movie::whereIn('id', $manyGenre)->withCount('episodes')->orderBy('created_at', 'DESC')->paginate(12);
        $listTrailerMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status_movie', 2)->get();

        return view('pages.genre', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listGenreBySlug',
            'listMovieBySlug',
            'listTrailerMovies',
        ));
    }
    public function episode()
    {
        return view('pages.episode');
    }

    public function watch($slug, $episode)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->where('status', 1)->get();

        $listMovieBySlug = Movie::with('category', 'genre', 'country', 'movieGenre')->where('slug', $slug)->where('status', 1)->first();

        if (isset($episode)) {
            $episode = $episode;
            $episode = substr($episode, 4, 20);
            $firstEpisode = Episode::with('movie')->where('movie_id', $listMovieBySlug->id)->first();
        } else {
            $episode = 1;
            $firstEpisode = Episode::with('movie')->where('movie_id', $listMovieBySlug->id)->first();
        }

        $listEpisode = Episode::where('movie_id', $listMovieBySlug->id)->where('slug', $episode)->first();

        $listMovieRelates = Movie::with('category', 'genre', 'country')
            ->where('category_id', $listMovieBySlug->category->id)
            ->where('status', 1)
            ->whereNotIn('slug', [$slug])
            ->orderBy(DB::raw('RAND()'))
            ->get();
        $listTrailerMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status_movie', 2)->get();

        return view('pages.watch', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listMovieBySlug',
            'listEpisode',
            'episode',
            'listMovieRelates',
            'listTrailerMovies'
        ));
    }
    public function movie($slug)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->where('status', 1)->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->where('status', 1)->get();

        $listMovieBySlug = Movie::withCount('episodes')->with('category', 'genre', 'country', 'movieGenre')
            ->where('slug', $slug)
            ->where('status', 1)
            ->first();

        $listMovieRelate = Movie::with('category', 'genre', 'country')
            ->withCount('episodes')
            ->where('category_id', $listMovieBySlug->category->id)
            ->where('status', 1)
            ->whereNotIn('slug', [$slug])
            ->orderBy(DB::raw('RAND()'))
            ->get();

        // Get 3 episode current
        $listEpisode = Episode::with('movie')
            ->where('movie_id', $listMovieBySlug->id)->orderBy('name', 'DESC')->take(3)->get();
        // Get 1 episode
        $firstEpisode = Episode::with('movie')
            ->where('movie_id', $listMovieBySlug->id)->first();
        // Count Episode
        $countEpisode = Episode::with('movie')
            ->where('movie_id', $listMovieBySlug->id)->get()->count();

        $rating = Rating::where('movie_id', $listMovieBySlug->id)->avg('rating');
        $rating = round($rating);

        $countTotal = Rating::where('movie_id', $listMovieBySlug->id)->count();

        // Increase movie view
        $countView = $listMovieBySlug->count_view;
        $countView += 1;
        $listMovieBySlug->count_view = $countView;

        return view('pages.movie', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listMovieBySlug',
            'listMovieRelate',
            'listEpisode',
            'firstEpisode',
            'countEpisode',
            'rating',
            'countTotal'
        ));
    }

    public function year($year)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->get();

        $listMovieByYear = Movie::where('year', $year)->withCount('episodes')
            ->paginate(20);
        $listHotMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status', 1)->where('movie_hot', 1)->get();
        $listTrailerMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status_movie', 2)->get();

        return view('pages.year', compact(
            'listCategories',
            'listGenres',
            'listCountries',
            'listMovieByYear',
            'year',
            'listTrailerMovies',
        ));
    }

    public function tag($tag)
    {
        $listCategories = Category::orderBy('created_at', 'DESC')->get();
        $listGenres = Genre::orderBy('created_at', 'DESC')->get();
        $listCountries = Country::orderBy('created_at', 'DESC')->get();

        $listMovieByTag = Movie::where('tags', 'LIKE', '%' . $tag . '%')->withCount('episodes')
            ->paginate(20);

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

            $listMovieBySearch = Movie::where('title', 'LIKE', '%' . $search . '%')->withCount('episodes')->paginate(10);
            $listHotMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status', 1)->where('movie_hot', 1)->get();
            $listTrailerMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status_movie', 2)->get();

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

    public function filter()
    {
        $order = $_GET['order'];
        $genre = $_GET['genre'];
        $country = $_GET['country'];
        $year = $_GET['year'];
        if (empty($order) && empty($genre) && empty($country) && empty($year)) {
            return redirect()->back();
        } else {
            $listCategories = Category::orderBy('created_at', 'DESC')->get();
            $listGenres = Genre::orderBy('created_at', 'DESC')->get();
            $listCountries = Country::orderBy('created_at', 'DESC')->get();
            $listTrailerMovies = Movie::orderBy('created_at', 'ASC')->withCount('episodes')->where('status_movie', 2)->get();

            $listMovies = Movie::withCount('episodes');
            if ($genre) {
                $listMovies = $listMovies->where('genre_id', '=', $genre);
            }
            if ($country) {
                $listMovies = $listMovies->where('country_id', '=', $country);
            }
            if ($year) {
                $listMovies = $listMovies->where('year', '=', $year);
            }
            if ($order) {
                $listMovies = $listMovies->orderBy('title', 'ASC');
            }
            $listMovies = $listMovies->orderBy('created_at', 'DESC')->paginate(20);
            return view('pages.filter', compact(
                'listCategories',
                'listGenres',
                'listCountries',
                'listMovies',
                'listTrailerMovies'
            ));
        }
    }
}