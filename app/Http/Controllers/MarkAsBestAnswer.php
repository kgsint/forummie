<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBestAnswerRequest;
use App\Models\Post;
use App\Models\Thread;

class MarkAsBestAnswer extends Controller
{
    public function __invoke(UpdateBestAnswerRequest $request, Thread $thread, Post $post)
    {
        // update solution_post_id in threads table
        // if there is no post_id, it'll set back to null
        $thread->solution()->associate(Post::find($request->post_id));
        $thread->save();

        return redirect()->route('forum.show', ['thread' => $thread, 'post' => $post->id]);
    }
}
