<?php

namespace App\Jobs;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\SomeoneReplyYourThread;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NotifyThreadOwner implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private User $user, private Thread $thread, private string $redirectUrl)
    {
        //
    }

    public function handle(): void
    {
        $this->thread->user
                        ->notify(
                            new SomeoneReplyYourThread(
                                user: $this->user,
                                thread: $this->thread,
                                url: $this->redirectUrl
                            ),
                        );

        // remove cache
        Cache::forget('notifications');
    }
}
