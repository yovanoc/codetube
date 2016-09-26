<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->q) {
            return redirect('/');
        }

        $channels = Channel::search($request->q)->take(2)->get();
        $videos = Video::search($request->q)->get();

        return view('search.index', [
            'channels' => $channels,
            'videos' => $videos
        ]);
    }
}
