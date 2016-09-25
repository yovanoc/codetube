<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

use App\Http\Requests;

class EncodingWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $event = camel_case($request->event);

        if (method_exists($this, $event)) {
            $this->{$event}($request);
        }
    }

    protected function videoEncoded(Request $request)
    {
        $video = $this->getVideoByFileName($request->original_filename);

        $video->processed = true;
        $video->video_id = $request->encoding_ids[0];
        $video->save();
    }

    protected function encodingProgress(Request $request)
    {
        $video = $this->getVideoByFileName($request->original_filename);

        $video->processed_percentage = $request->progress;
        $video->save();
    }

    protected function getVideoByFileName($fileName)
    {
        return Video::where('video_filename', $fileName)->firstOrFail();
    }
}
