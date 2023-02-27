<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listMovies = Movie::with('category', 'genre', 'country')->orderBy('id', 'DESC')->get();
        $listGenres = Genre::pluck('title', 'id');
        $listCountries = Country::pluck('title', 'id');
        $listCategories = Category::pluck('title', 'id');
        return view('admin.movie.form', compact('listMovies', 'listGenres', 'listCountries', 'listCategories'));
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
        $newMovie->description = $data['description'];
        $newMovie->status = $data['status'];
        $newMovie->category_id = $data['category_id'];
        $newMovie->genre_id = $data['genre_id'];
        $newMovie->country_id = $data['country_id'];

        $getImage = $request->file('image');
        $newMovie->image = '';


        if ($getImage) {
            $newImage = Str::uuid()->toString() . '.' . $getImage->getClientOriginalExtension();
            $getImage->move(MovieController::PATH, $newImage);

            $newMovie->image = $newImage;
        }
        $newMovie->save();
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
        $listGenres = Genre::pluck('title', 'id');
        $listCountries = Country::pluck('title', 'id');
        $listCategories = Category::pluck('title', 'id');

        $listMovieById = Movie::find($id);

        return view('admin.movie.form', compact(
            'listMovies',
            'listGenres',
            'listCountries',
            'listCategories',
            'listMovieById'
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
        $updateMovie->description = $data['description'];
        $updateMovie->status = $data['status'];
        $updateMovie->category_id = $data['category_id'];
        $updateMovie->genre_id = $data['genre_id'];
        $updateMovie->country_id = $data['country_id'];

        $getImage = $request->file('image');
        print_r($getImage);
        if ($getImage) {
            if (!empty($updateMovie)) {
                unlink(MovieController::PATH . '/' . $updateMovie->image);
            }

            $newImage = Str::uuid()->toString() . '.' . $getImage->getClientOriginalExtension();
            $getImage->move(MovieController::PATH, $newImage);
            $updateMovie->image = $newImage;
        }
        $updateMovie->save();
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

        if (!empty($findMovieById)) {
            unlink(MovieController::PATH . '/' . $findMovieById->image);
        }

        $findMovieById->delete();
        return redirect()->back();
    }
}