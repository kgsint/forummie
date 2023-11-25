<?php

namespace App\Observers;

use App\Models\Thread;
use App\Models\User;

class ThreadObserver
{
    public function created(Thread $thread)
    {
        preg_match_all('/(\@(?P<username>[a-zA-Z\-\_]+))/', $thread->body, $mentions, PREG_SET_ORDER);
        // /(\@(?P<username>[a-zA-Z\-\_]+))/

        // dd(collect($mentions)->pluck('username'));

        $IdsTosync = User::whereIn(
                                'username', collect($mentions)
                                ->pluck('username')) // where username in [1, 3, .. or so]
                                ->pluck('id'); // pluck (id(s) as array to sync in thread_mention pivot table)

        $thread->mentions()->sync($IdsTosync);
    }
}
