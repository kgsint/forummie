<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\Thread;

class PostController extends Controller
{
    public function store(PostStoreRequest $request, Thread $thread)
    {
        $post = Post::create([
            'body' => $request->body,
            'thread_id' => $thread->id,
            'parent_id' => $request->parent_id,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('forum.show', ['thread' => $thread, 'post' => $post->id]);
    }

    public function update(PostUpdateRequest $request, Thread $thread, Post $post)
    {
        $post->update([
            'body' => $request->body
        ]);

        return redirect()->route('forum.show', ['thread' => $thread, 'post' => $post->id]);
    }

    public function destroy(Thread $thread, Post $post)
    {
        // authorize
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('forum.show', $thread);
    }
}
