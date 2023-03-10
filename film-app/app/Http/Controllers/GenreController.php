<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listGenres  = Genre::orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.genre.index', compact('listGenres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.genre.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:genres|max:500',
            'slug' => 'required|unique:genres|max:500',
            'description' => 'required|max:500',
            'status' => 'required',
        ], [
            'title.unique' => 'Title already exist. Please try change title',
            'slug.unique' => 'Slug already exist. Please try change slug',
            'title.required' => 'Title is required',
            'slug.required' => 'Slug is required',
            'description.required' => 'Description is required',
            'status.required' => 'Status is required',
            'title' => 'Title max character 500. Please input few than.',
            'slug' => 'Title max character 500. Please input few than.'
        ]);

        $newGenre = new Genre();
        $newGenre->id = Str::random(24);
        $newGenre->title = $data['title'];
        $newGenre->slug = $data['slug'];
        $newGenre->description = $data['description'];
        $newGenre->status = $data['status'];
        $newGenre->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $newGenre->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

        $newGenre->save();
        toastr()->success('Data has been saved successfully!', 'Congrats');
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
        $listGenreById = Genre::find($id);
        return view('admin.genre.form', compact('listGenreById'));
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
        $data = $request->validate([
            'title' => 'required|unique:categories|max:500',
            'slug' => 'required|unique:categories|max:500',
            'description' => 'required|max:500',
            'status' => 'required',
        ], [
            'title.unique' => 'Title already exist. Please try change title',
            'slug.unique' => 'Slug already exist. Please try change slug',
            'title.required' => 'Title is required',
            'slug.required' => 'Slug is required',
            'description.required' => 'Description is required',
            'status.required' => 'Status is required',
            'title' => 'Title max character 500. Please input few than.',
            'slug' => 'Title max character 500. Please input few than.'
        ]);

        $updateGenre = Genre::find($id);
        $updateGenre->title = $data['title'];
        $updateGenre->slug = $data['slug'];
        $updateGenre->description = $data['description'];
        $updateGenre->status = $data['status'];
        $updateGenre->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

        $updateGenre->save();
        toastr()->success('Data has been updated successfully!', 'Congrats');
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
        Genre::find($id)->delete();
        toastr()->success('Data has been deleted successfully!', 'Congrats');
        return redirect()->back();
    }

    public function genreStatus(Request $request)
    {
        $data = $request->all();
        $getGenreById = Genre::where('id', $data['genreId'])->first();
        $getGenreById->status = $data['genreStatus'];

        $getGenreById->save();
    }
}