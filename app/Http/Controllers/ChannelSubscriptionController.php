<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelSubscriptionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /**
     * @param Request $request
     * @param Channel $channel
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Channel $channel)
    {
        $response = [
            'count' => $channel->subscriptionCount(),
            'user_subscribed' => false,
            'can_subscribe' => false
        ];
        if ($request->user()) {
            $response = array_merge($response, [
                'user_subscribed' => $request->user()->isSubscribedTo($channel),
                'can_subscribe' => !$request->user()->ownsChannel($channel)
            ]);
        }
        return response()->json($response, 200);
    }

    public function create(Request $request, Channel $channel)
    {
        $this->authorize('subscribe', $channel);
        $request->user()->subscriptions()->create([
            'channel_id' => $channel->id
        ]);
        return response()->json(null, 200);
    }

    public function delete(Request $request, Channel $channel)
    {
        $this->authorize('unSubscribe', $channel);
        $request->user()->subscriptions()->where('channel_id', $channel->id)->delete();
        return response()->json(null, 200);
    }
}
