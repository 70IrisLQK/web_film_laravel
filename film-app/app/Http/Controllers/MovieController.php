<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use UtilHelper;

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
        $listMovies = Movie::with('country', 'category', 'movieGenre', 'genre')
            ->withCount('episodes')
            ->orderBy('id', 'DESC')
            ->orderBy('created_at', "DESC")
            ->paginate();

        $categories = Category::pluck('title', 'id');
        $countries = Country::pluck('title', 'id');

        $destinationPath = public_path() . "/json/";

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        FacadesFile::put($destinationPath . 'movie.json', json_encode($listMovies));
        return view('admin.movie.index', compact(
            'listMovies',
            'categories',
            'countries'
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
        $listCategories = Category::pluck('title', 'id');
        $listCountries = Country::pluck('title', 'id');

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
        $data = $request->validate([
            'title' => 'required|max:500',
            'slug' => 'required|max:500',
            'lang' => 'required|max:500',
            'origin_name' => 'required|max:500',
            'trailer_url' => 'required|max:500',
            'description' => 'required',
            'type' => 'required',
            'episode_total' => 'required',
            'time' => 'required',
            'tags' => 'required',
            'quality' => 'required',
            'movie_hot' => 'required',
            'category_id' => 'required',
            'country_id' => 'required',
            'most_view' => 'required',
            'status' => 'required',
            'status_movie' => 'required',
            'genre' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ], [
            'title.required' => 'Title is required',
            'slug.required' => 'Slug is required',
            'lang.required' => 'Language is required',
            'origin_name.required' => 'Original Title is required',
            'trailer_url.required' => 'Trailer is required',
            'description.required' => 'Description is required',
            'episode_total.required' => 'Episode Total is required',
            'type.required' => 'Type movie is required',
            'time.required' => 'Time is required',
            'tags.required' => 'Tags is required',
            'quality.required' => 'Quality is required',
            'movie_hot.required' => 'Movie hot is required',
            'category_id.required' => 'Category is required',
            'country_id.required' => 'Country is required',
            'most_view.required' => 'Most View is required',
            'status.required' => 'Status is required',
            'status_movie.required' => 'Status Movie is required',
            'image.required' => 'Image is required',
            'image.image' => 'Image is required type image',
            'image.mimes' => 'Image is required type jpg, png, jpeg, gif, svg',
        ]);
        $newMovie = new Movie();
        $newMovie->id = Str::random(24);
        $newMovie->title = $data['title'];
        $newMovie->slug = $data['slug'];
        $newMovie->lang = $data['lang'];
        $newMovie->origin_name = $data['origin_name'];
        $newMovie->trailer_url = $data['trailer_url'];
        $newMovie->episode_total = $data['episode_total'];
        $newMovie->type = $data['type'];
        $newMovie->time = $data['time'];
        $newMovie->tags = $data['tags'];
        $newMovie->description = $data['description'];
        $newMovie->status = $data['status'];
        $newMovie->status_movie = $data['status_movie'];
        $newMovie->quality = $data['quality'];
        $newMovie->movie_hot = $data['movie_hot'];
        $newMovie->category_id = $data['category_id'];
        $newMovie->country_id = $data['country_id'];
        $newMovie->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $newMovie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $newMovie->genre_id = array_shift($data['genre']);
        $newMovie->link_image = '';
        $newMovie->episode_current = 1;
        $newMovie->view = 1;
        $newMovie->season = 0;
        $newMovie->year = 2010;
        $newMovie->actor = '';
        $newMovie->director = '';

        $getImage = $request->file('image');
        $newMovie->image = '';


        if ($getImage) {
            $newImage = Str::uuid()->toString() . '.' . $getImage->getClientOriginalExtension();
            $getImage->move(MovieController::PATH, $newImage);

            $newMovie->image = $newImage;
        }
        $newMovie->save();

        $newMovie->movieGenre()->attach($data['genre']);
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
        $updateMovie->belong_movie = $data['belong_movie'];
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
        toastr()->success('Data has been updated successfully!', 'Congrats');
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

        if (file_exists(MovieController::PATH . '/' . $findMovieById->image) && !empty($findMovieById->image)) {
            unlink(MovieController::PATH . '/' . $findMovieById->image);
        }

        $findMovieById->delete();
        toastr()->success('Data has been deleted successfully!', 'Congrats');
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
    public function selectTopView(Request $request)
    {
        $data = $request->all();

        $findMovieById = Movie::find($data['id']);
        $findMovieById->top_view = $data['topView'];
        $findMovieById->save();
    }

    public function filterTopView(Request $request)
    {
        $data = $request->all();
        $movies = Movie::where('most_view', $data['value'])->orderBy('created_at', 'DESC')->take(7)->get();
        $output = '';
        foreach ($movies as $key => $movie) {
            if ($movie->quality == 0) {
                $text = 'CAM';
            } else if ($movie->quality == 1) {
                $text = 'SD';
            } else if ($movie->quality == 2) {
                $text = 'HD';
            } else if ($movie->quality == 3) {
                $text = 'Full HD';
            } else {
                $text = 'Trailer';
            }
            $output .= '
            <div class="item post-37176">
            <a href="' . url('movies/' . $movie->slug) . '" title="' . $movie->title . '">
                <div class="item-link">
                    <img src="' . url('uploads/movies/' . $movie->image) . '"
                        class="lazy post-thumb" alt="' . $movie->title . '"
                        title="' . $movie->title . '" />
                    <span class="is_trailer">' . $text . '</span>
                </div>
                <p class="title">' . $movie->title . '</p>
            </a>
            <div class="viewsCount" style="color: #9d9d9d;">' . $this->thousandsCurrencyFormat($movie->view) . ' lượt xem</div>
            <div style="float: left;">
                <span class="user-rate-image post-large-rate stars-large-vang"
                    style="display: block;/* width: 100%; */">
                    <span style="width: 0%"></span>
                </span>
            </div>
        </div>
            ';
        }
        echo $output;
    }
    public function filterTopViewDefault()
    {
        $movies = Movie::where('most_view', 0)->orderBy('created_at', 'DESC')->take(7)->get();
        $output = '';
        foreach ($movies as $key => $movie) {
            if ($movie->quality == 0) {
                $text = 'CAM';
            } else if ($movie->quality == 1) {
                $text = 'SD';
            } else if ($movie->quality == 2) {
                $text = 'HD';
            } else if ($movie->quality == 3) {
                $text = 'Full HD';
            } else {
                $text = 'Trailer';
            }
            $output .= '
            <div class="item post-37176">
            <a href="' . url('movies/' . $movie->slug) . '" title="' . $movie->title . '">
                <div class="item-link">
                    <img src="' . url('uploads/movies/' . $movie->image) . '"
                        class="lazy post-thumb" alt="' . $movie->title . '"
                        title="' . $movie->title . '" />
                    <span class="is_trailer">' . $text . '</span>
                </div>
                <p class="title">' . $movie->title . '</p>
            </a>
            <div class="viewsCount" style="color: #9d9d9d;">' . $this->thousandsCurrencyFormat($movie->view) . ' lượt xem</div>
            <div style="float: left;">
                <span class="user-rate-image post-large-rate stars-large-vang"
                    style="display: block;/* width: 100%; */">
                    <span style="width: 0%"></span>
                </span>
            </div>
        </div>
            ';
        }
        echo $output;
    }

    public function categoryChoose(Request $request)
    {
        $data = $request->all();
        $getMovieById = Movie::find($data['movieId']);
        $getMovieById->category_id = $data['categoryId'];

        $getMovieById->save();
    }

    public function countryChoose(Request $request)
    {
        $data = $request->all();
        $getMovieById = Movie::find($data['movieId']);
        $getMovieById->country_id = $data['countryId'];

        $getMovieById->save();
    }

    public function statusChoose(Request $request)
    {
        $data = $request->all();
        $getMovieById = Movie::find($data['movieId']);
        $getMovieById->status = $data['status'];

        $getMovieById->save();
    }

    public function resolutionChoose(Request $request)
    {
        $data = $request->all();
        $getMovieById = Movie::find($data['movieId']);
        $getMovieById->resolution = $data['resolution'];

        $getMovieById->save();
    }

    public function hotChoose(Request $request)
    {
        $data = $request->all();
        $getMovieById = Movie::find($data['movieId']);
        $getMovieById->movie_hot = $data['hot'];

        $getMovieById->save();
    }

    public function subtitleChoose(Request $request)
    {
        $data = $request->all();
        $getMovieById = Movie::find($data['movieId']);
        $getMovieById->subtitle = $data['subtitle'];

        $getMovieById->save();
    }

    public function belongMovieChoose(Request $request)
    {
        $data = $request->all();
        $getMovieById = Movie::find($data['movieId']);
        $getMovieById->belong_movie = $data['belongMovie'];

        $getMovieById->save();
    }

    public function runJson()
    {
        $json = Storage::disk('local')->get('/json/movies.json');
        $movies = json_decode($json, true);
        $arrayMovie = array($movies);
        $addMovie = new Movie();

        foreach ($arrayMovie as $movie) {
            if ($movie['movie']['type'] == 'single') {
                $type = 0;
                $categoryId = 'vhLWKX5vFcY6ZSjnRtgXa2xH';
            } else if ($movie['movie']['type'] == 'series') {
                $type = 1;
                $categoryId = 'qYdYwB9Ne1WvK4FdANWM3MaN';
            } else if ($movie['movie']['type'] == 'tvshows') {
                $type = 3;
                $categoryId = 'f0qP6SdIzR4ENS8LlkUx3mrq';
            } else {
                $type = 2;
                $categoryId = 'Ul8QiTrLdueZr78hlol3S4yH';
            }
            if ($movie['movie']['status'] == 'ongoing') {
                $statusMovie = 0;
            } else if ($movie['movie']['status'] == 'completed') {
                $statusMovie = 1;
            } else {
                $statusMovie = 2;
            }



            $addMovie->id = Str::random(24);
            $addMovie->title = $movie['movie']['name'] ?? '';
            $addMovie->origin_name = $movie['movie']['origin_name'] ?? '';
            $addMovie->type = $movie['movie']['type'] ?? '';
            $addMovie->description = $movie['movie']['content'] ?? '';
            $addMovie->status = 1;
            $addMovie->movie_hot = 1;
            $addMovie->link_image =  $movie['movie']['poster_url'] ?? '';
            $addMovie->time = $movie['movie']['time'] ?? '';
            $addMovie->episode_current = $movie['movie']['episode_current'] ?? '';
            $addMovie->episode_total = $movie['movie']['episode_total'] ?? '';
            $addMovie->quality = $movie['movie']['quality'] ?? '';
            $addMovie->slug = $movie['movie']['slug'] ?? '';
            $addMovie->year = $movie['movie']['year'] ?? '';
            $addMovie->view = $movie['movie']['view'] ?? '';
            $addMovie->image = '';
            $addMovie->country_id = $movie['movie']['country'][0]['id'];
            $addMovie->actor = implode(",", $movie['movie']['actor']) ?? '';
            $addMovie->director = implode(",", $movie['movie']['director']) ?? '';
            $addMovie->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $addMovie->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $addMovie->category_id = $categoryId;
            $addMovie->type = $type;
            $addMovie->quality = $movie['movie']['quality'] == 'Full HD' ? '3' : '2';
            $addMovie->lang = $movie['movie']['lang'] == 'Vietsub' ? '0' : '1';
            $addMovie->status_movie = $statusMovie;
            $addMovie->genre_id = $movie['movie']['category'][0]['id'];
            $addMovie->tags = '';
            $addMovie->save();

            foreach ($movie['movie']['category'] as $cate) {
                MovieGenre::insert([[
                    'movie_id' => $addMovie->id,
                    'genre_id' => $cate['id']
                ]]);
            }

            foreach ($movie['episodes'] as $value) {
                foreach ($value['server_data'] as  $server) {
                    Episode::insert([[
                        'server_name' => $value['server_name'],
                        'link_embed' => $server['link_embed'],
                        'link_m3u8' => $server['link_m3u8'],
                        'name' => $server['name'],
                        'movie_id' => $addMovie->id,
                        'filename' => $server['filename'],
                        'slug' => $server['slug'],
                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                        'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                    ]]);
                }
            }
        }



        // $addMovie->save();

        // foreach ($movies['episodes'] as $episode) {
        //     $addEpisode->server_name = $episode['server_name'];
        //     foreach ($episode['server_data'] as $key => $value) {
        //         $addEpisode->link = $value['link_embed'];
        //         $addEpisode->episode = $value['name'];
        //         $addEpisode->movie_id  = $addMovie->id;

        //         $addEpisode->filename = $value['filename'];
        //         $addEpisode->slug = $value['slug'];
        //         $addEpisode->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        //         $addEpisode->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        //         $addEpisode->status = 1;
        //         $addEpisode->save();
        //     }
        // }
        // $addMovie->movieGenre()->attach($movies['movie']['category']);
    }
    function thousandsCurrencyFormat($num)
    {

        if ($num > 1000) {

            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;
        }

        return $num;
    }
}