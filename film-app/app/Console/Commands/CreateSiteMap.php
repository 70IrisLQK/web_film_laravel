<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App as FacadesApp;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sitemap = FacadesApp::make('sitemap');
        // add home pages mặc định
        $sitemap->add(URL::to('/'), Carbon::now('Asia/Ho_Chi_Minh'), '1.0', 'daily');

        $genres = Genre::orderBy('created_at', 'desc')
            ->get();
        foreach ($genres as $genre) {
            $sitemap->add(env('APP_URL') . "/genres/" . $genre->slug, Carbon::now('Asia/Ho_Chi_Minh'), '0.7', 'daily');
        }

        $categories = Category::orderBy('created_at', 'desc')
            ->get();
        foreach ($categories as $category) {
            $sitemap->add(env('APP_URL') . "/categories/" . $category->slug, Carbon::now('Asia/Ho_Chi_Minh'), '0.7', 'daily');
        }

        $countries = Category::orderBy('created_at', 'desc')
            ->get();
        foreach ($countries as $country) {
            $sitemap->add(env('APP_URL') . "/countries/" . $country->slug, Carbon::now('Asia/Ho_Chi_Minh'), '0.7', 'daily');
        }

        $movies = Movie::orderBy('created_at', 'desc')
            ->get();
        foreach ($movies as $movie) {
            $sitemap->add(env('APP_URL') . "/movies/" . $movie->slug, Carbon::now('Asia/Ho_Chi_Minh'), '0.7', 'daily');
        }

        //Get episode;
        $episodes = Episode::all();
        foreach ($movies as $key => $movie) {
            foreach ($episodes as $key => $episode) {
                if ($movie->id == $episode->movie_id) {
                    $sitemap->add(env('APP_URL') . "/watch/" . $movie->slug . "/episode-" . $episode->episode, Carbon::now('Asia/Ho_Chi_Minh'), '0.7', 'daily');
                }
            }
        }


        // lưu file và phân quyền
        $sitemap->store('xml', 'sitemap');
        if (file_exists(public_path() . '/sitemap.xml')) {
            chmod(public_path() . '/sitemap.xml', 0777);
        }
    }
}