<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function createRating(Request $request)
    {
        $data = $request->all();
        $ipAddress = $request->ip();
        $ratingCount = Rating::where('movie_id', $data['movie_id'])->where('ip_address', $ipAddress)->count();

        if ($ratingCount > 0) {
            echo 'exist';
        } else {
            $newRating = new Rating();
            $newRating->movie_id = $data['movie_id'];
            $newRating->ip_address = $ipAddress;
            $newRating->rating = $data['index'];
            $newRating->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $newRating->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $newRating->save();
            echo 'done';
        }
    }
}