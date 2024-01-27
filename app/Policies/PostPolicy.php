<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        $post->load('user');

        return $user->is($post->user) ||
                    $post->user->isUser() && ($user->isAdmin() || $user->isModerator());
    }
}
