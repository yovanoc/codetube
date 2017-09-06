<?php

namespace App\Http\Controllers;

use App\Jobs\UploadVideo;
use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('videos.upload');
    }

    public function store(Request $request)
    {
        $channel = $request->user()->channel()->first();

        $video = $channel->videos()->where('uid', $request->uid)->firstOrFail();

        $request->file('video')->move(storage_path() . '/uploads', $video->video_filename);

        $this->dispatch(new UploadVideo($video->video_filename));

        return response()->json(null, 200);
    }
}
