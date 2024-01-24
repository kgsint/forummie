<?php

namespace App\Http\Controllers;

use App\Jobs\LikeReplyPost;
use App\Jobs\UnlikeReplyPost;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeUnLikeController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        $user = $request->user();

        if($post->isAlreadyLikedBy($user)) {
            (new UnlikeReplyPost($post, $user))->handle();
        }else {
            (new LikeReplyPost($post, $user))->handle();
        }

        return redirect(route('forum.show', ['thread' => $post->thread->slug, 'post' => $post->id]));
    }
}
