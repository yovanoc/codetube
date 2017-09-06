<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function videosFromSubscriptions(User $user, $limit = 5)
    {
        return $user->subscribedChannels()->with(['videos' => function ($query) use ($limit) {
            $query->visible()->take($limit);
        }])->get()->pluck('videos')->flatten()->sortByDesc('created_at');
    }
}
