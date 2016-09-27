<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @param UserRepository $users
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UserRepository $users)
    {
        $videos = $users->videosFromSubscriptions($request->user(), 5);

        return view('home', [
            'subscriptionVideos' => $videos
        ]);
    }
}
