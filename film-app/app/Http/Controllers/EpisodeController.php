<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listMovies = Movie::orderBy('id', 'DESC')->pluck('title', 'id');
        $listEpisodes = Episode::with('movie')->orderBy('id', 'DESC')->paginate(10);

        return view('admin.episode.index', compact('listMovies', 'listEpisodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listMovies = Movie::orderBy('id', 'DESC')->pluck('title', 'id');
        return view('admin.episode.form', compact('listMovies'));
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

        $checkEpisode = Episode::where('episode', $data['episode'])->where('movie_id', $data['movie_id'])->count();

        if ($checkEpisode) {
            return redirect()->back();
        } else {

            $newEpisode = new Episode();
            $newEpisode->id = Str::random(24);
            $newEpisode->movie_id = $data['movie_id'];
            $newEpisode->link = $data['link'];
            $newEpisode->episode = $data['episode'];
            $newEpisode->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $newEpisode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $newEpisode->save();
        }

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
        $listEpisodeById = Episode::find($id);
        $listEpisodes = Episode::all();
        $listMovies = Movie::orderBy('id', 'DESC')->pluck('title', 'id');
        return view('admin.episode.form', compact('listEpisodeById', 'listEpisodes', 'listMovies'));
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
        $updateEpisode = Episode::find($id);
        $updateEpisode->movie_id = $data['movie_id'];
        $updateEpisode->link = $data['link'];
        $updateEpisode->episode = $data['episode'];
        $updateEpisode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

        $updateEpisode->save();
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
        Episode::find($id)->delete();
        toastr()->success('Data has been deleted successfully!', 'Congrats');
        return redirect()->back();
    }

    public function selectMovie()
    {
        $movieId = $_GET['movieId'];
        $listMovieById = Movie::find($movieId);
        $output = '<option>Choose Episode</option>';

        if ($listMovieById->type == 1) {
            for ($i = 1; $i <= $listMovieById->episode_total; $i++) {
                $output .= '<option value="' . $i . '">' . $i . '</option>';
            }
        } else {
            $output .= '<option value="CAM">CAM</option>
            <option value="SD">SD</option> 
            <option value="HD">HD</option><option value="Full HD">HD</option>';
        }
        echo $output;
    }
}