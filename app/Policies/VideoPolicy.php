<?php

namespace App\Policies;

use App\Models\{User, Video};
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Video $video)
    {
        return $user->id === $video->channel->user_id;
    }

    public function update(User $user, Video $video)
    {
        return $user->id === $video->channel->user_id;
    }

    public function delete(User $user, Video $video)
    {
        return $user->id === $video->channel->user_id;
    }

    public function vote(User $user, Video $video)
    {
        if (!$video->canBeAccessed($user)) {
            return false;
        }

        return $video->votesAllowed();
    }

    public function comment(User $user, Video $video)
    {
        if (!$video->canBeAccessed($user)) {
            return false;
        }

        return $video->commentsAllowed();
    }
}
