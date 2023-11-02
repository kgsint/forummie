<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\ThreadResource;
use App\Models\Post;
use App\Models\Thread;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ForumController extends Controller
{
    public function index()
    {
        return Inertia::render('Forum/Index', [
            'threads' => ThreadResource::collection(
                Thread::with(['topic', 'user', 'latestPost'])
                                            ->orderBy('created_at', 'desc')
                                            ->paginate(10)
            ),
        ]);
    }

    public function show(Thread $thread)
    {
        // eager load
        $thread->load(['topic', 'user']);

        return Inertia::render('Forum/Show', [
            'thread' => new ThreadResource($thread),
            'posts' => PostResource::collection(
                                    Post::whereBelongsTo($thread)
                                                                ->with(['user', 'thread', 'replies'])
                                                                ->whereNull('parent_id')
                                                                ->oldest()
                                                                ->paginate(10)
                                ),
        ]);
    }
}
