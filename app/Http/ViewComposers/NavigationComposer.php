<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class NavigationComposer
{
    public function compose(View $view)
    {
        if (!auth()->check()) {
            return;
        }

        $view->with('channel', auth()->user()->channel->first());
    }
}
