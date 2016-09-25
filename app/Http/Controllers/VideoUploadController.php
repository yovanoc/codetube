<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Jobs\UploadVideo;
use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
    public function index()
    {
        return view('video.upload');
    }

    public function store(Request $request)
    {
        $channel = $request->user()->channel()->first();

        $video = $channel->videos()->where('uid', $request->uid)->firstOrFail();

        $request->file('video')->move(storage_path() . '/uploads', $video->video_filename);

        $this->dispatch(new UploadVideo(
            $video->video_filename
        ));

        return response()->json(null, 200);
    }
}
