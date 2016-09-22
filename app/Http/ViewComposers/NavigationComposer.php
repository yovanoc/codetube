<?php

namespace App\Http\ViewComposers;

use Auth;
use Illuminate\View\View;

class NavigationComposer
{
    public function compose(View $view)
    {
        if (!Auth::check()) {
            return;
        }

        $view->with('channel', Auth::user()->channel->first());
    }
}