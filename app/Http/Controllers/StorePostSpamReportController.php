<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Thread;
use Illuminate\Http\Request;

class StorePostSpamReportController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        // forbidden if already reported as spam
        if($post->isAlreadyReportedAsSpamBy($request->user())) {
            return response()->json([
                'message' => 'You have already reported this reply',
            ], 403);
        }

        // persist into db
        $post->reportAsSpamBy($request->user());

        // succcess message
        return response()->json([
            'message' => 'This reply has been reported as spam',
        ], 200);
    }
}
