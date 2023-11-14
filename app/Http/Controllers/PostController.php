<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Thread;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(StorePostRequest $request, Thread $thread)
    {
        Post::create([
            'body' => $request->body,
            'thread_id' => $thread->id,
            'parent_id' => $request->parent_id,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('forum.show', $thread);
    }
}
