<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File as FacadesFile;

class MovieController extends Controller
{
    public const PATH = 'uploads/movies';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listMovies = Movie::with('category', 'movieGenre', 'country', 'genre')
            ->orderBy('id', 'DESC')
            ->orderBy('created_at', "DESC")
            ->paginate(10);

        $destinationPath = public_path() . "/json/";
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        FacadesFile::put($destinationPath . 'movie.json', json_encode($listMovies));

        return view('admin.movie.index', compact(
            'listMovies',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listMovies = Movie::with('category', 'movieGenre', 'country', 'genre')->orderBy('id', 'DESC')->get();

        $destinationPath = public_path() . "/json/";
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        FacadesFile::put($destinationPath . 'movie.json', json_encode($listMovies));

        $listGenres = Genre::orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->get();
        $listCategories = Category::orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->get();
        $listCountries = Country::orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->get();

        return view('admin.movie.form', compact(
            'listMovies',
            'listGenres',
            'listCountries',
            'listCategories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $newMovie = new Movie();
        $newMovie->title = $data['title'];
        $newMovie->slug = $data['slug'];
        $newMovie->subtitle = $data['subtitle'];
        $newMovie->original_title = $data['original_title'];
        $newMovie->trailer = $data['trailer'];
        $newMovie->duration = $data['duration'];
        $newMovie->tags = $data['tags'];
        $newMovie->description = $data['description'];
        $newMovie->status = $data['status'];
        $newMovie->resolution = $data['resolution'];
        $newMovie->movie_hot = $data['movie_hot'];
        $newMovie->category_id = $data['category_id'];
        $newMovie->country_id = $data['country_id'];
        $newMovie->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $newMovie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

        foreach ($data['genre'] as $key => $value) {
            $newMovie->genre_id = $value[0];
        }


        $getImage = $request->file('image');
        $newMovie->image = '';


        if ($getImage) {
            $newImage = Str::uuid()->toString() . '.' . $getImage->getClientOriginalExtension();
            $getImage->move(MovieController::PATH, $newImage);

            $newMovie->image = $newImage;
        }
        $newMovie->save();

        $newMovie->movieGenre()->attach($data['genre']);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listMovies = Movie::all();

        $listMovieById = Movie::with('country', 'category')->find($id);
        $listMovieGenre = $listMovieById->movieGenre;

        $listGenres = Genre::orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->get();
        $listCategories = Category::orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->get();
        $listCountries = Country::orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->get();

        return view('admin.movie.form', compact(
            'listMovies',
            'listGenres',
            'listCountries',
            'listCategories',
            'listMovieById',
            'listGenres',
            'listMovieGenre'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $updateMovie = Movie::find($id);

        $updateMovie->title = $data['title'];
        $updateMovie->subtitle = $data['subtitle'];
        $updateMovie->slug = $data['slug'];
        $updateMovie->original_title = $data['original_title'];
        $updateMovie->trailer = $data['trailer'];
        $updateMovie->duration = $data['duration'];
        $updateMovie->tags = $data['tags'];
        $updateMovie->description = $data['description'];
        $updateMovie->status = $data['status'];
        $updateMovie->resolution = $data['resolution'];
        $updateMovie->movie_hot = $data['movie_hot'];
        $updateMovie->category_id = $data['category_id'];
        $updateMovie->country_id = $data['country_id'];
        $updateMovie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

        foreach ($data['genre'] as $key => $value) {
            $updateMovie->genre_id = $value[0];
        }


        $getImage = $request->file('image');
        if ($getImage) {
            if (file_exists(MovieController::PATH . '/' . $updateMovie->image)) {
                unlink(MovieController::PATH . '/' . $updateMovie->image);
            } else {
                $newImage = Str::uuid()->toString() . '.' . $getImage->getClientOriginalExtension();
                $getImage->move(MovieController::PATH, $newImage);
                $updateMovie->image = $newImage;
            }
        }
        $updateMovie->save();

        $updateMovie->movieGenre()->sync($data['genre']);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findMovieById = Movie::find($id);

        if (file_exists(MovieController::PATH . '/' . $findMovieById->image)) {
            unlink(MovieController::PATH . '/' . $findMovieById->image);
        }

        $findMovieById->delete();
        return redirect()->back();
    }

    public function selectYear(Request $request)
    {
        $data = $request->all();
        $findMovieById = Movie::find($data['id']);
        $findMovieById->year = $data['year'];
        $findMovieById->save();
    }

    public function selectSeason(Request $request)
    {
        $data = $request->all();

        $findMovieById = Movie::find($data['id']);
        $findMovieById->season = $data['season'];
        $findMovieById->save();
    }
}