<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeUnLikeController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        if($post->isAlreadyLikedBy($request->user())) {
            $post->unlikeBy($request->user());
        }else {
            $post->likedBy($request->user());
        }

        // return back();
    }
}
