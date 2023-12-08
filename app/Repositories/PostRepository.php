<?php

namespace App\Repositories;

use App\Models\Post;
use App\Contracts\PostInterface;

class PostRepository implements PostInterface
{
    public function getAll()
    {
        return Post::latest()->paginate(Post::PAGINATION_COUNT);
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
