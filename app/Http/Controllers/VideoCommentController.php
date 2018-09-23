<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVideoCommentRequest;
use App\Models\Comment;
use App\Models\Video;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;

class VideoCommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * @param Video $video
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Video $video)
    {
        return response()->json(
            fractal()->collection($video->comments()->latestFirst()->get())
                ->parseIncludes(['channel', 'replies', 'replies.channel'])
                ->transformWith(new CommentTransformer())
                ->toArray()
        );
    }

    /**
     * @param CreateVideoCommentRequest $request
     * @param Video $video
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateVideoCommentRequest $request, Video $video)
    {
        $this->authorize('comment', $video);
        $comment = $video->comments()->create([
            'body' => $request->body,
            'reply_id' => $request->get('reply_id', null),
            'user_id' => $request->user()->id
        ]);
        return response()->json(
            fractal()->item($comment)
                ->parseIncludes(['channel', 'replies'])
                ->transformWith(new CommentTransformer())
                ->toArray()
        );
    }

    /**
     * @param Video $video
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Video $video, Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json(null, 200);
    }
}
