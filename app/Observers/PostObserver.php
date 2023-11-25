<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\User;

class PostObserver
{
    public function created(Post $post)
    {
        preg_match_all('/(\@(?P<username>[a-zA-Z\-\_]+))/', $post->body, $mentions, PREG_SET_ORDER);
        // mentioned users
        $idsToSync = User::whereIn(
            'username', collect($mentions)->pluck('username')
        )
        ->pluck('id');

        // sync with pivot table
        $post->mentions()->sync($idsToSync);
    }
}
