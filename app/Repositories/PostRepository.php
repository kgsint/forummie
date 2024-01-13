<?php

namespace App\Repositories;

use App\Models\Post;
use App\Contracts\PostInterface;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Builder;

class PostRepository implements PostInterface
{
    public function getAll()
    {
        return Post::latest()->paginate(Post::PAGINATION_COUNT);
    }

    public function getByThread(Thread $thread)
    {
        return Post::query()
                                ->whereBelongsTo($thread)
                                ->where(function(Builder $query) {
                                    return $query->whereNull('parent_id');
                                })
                                ->with(['user', 'thread.user', 'replies.thread.user', 'replies.parent', 'replies.user'])
                                ->oldest()
                                ->paginate(Post::PAGINATION_COUNT);
    }

    public function store(array $data)
    {
        return Post::create([
            'body' => $data['body'],
            'thread_id' => $data['thread_id'],
            'parent_id' => $data['parent_id'],
            'user_id' => $data['user_id'],
        ]);
    }

    public function update(Post $post, array $data)
    {
        $post->update([
            'body' => $data['body'],
        ]);

        return $post;
    }

    public function delete(Post $post)
    {
        $post->delete();
    }
}
