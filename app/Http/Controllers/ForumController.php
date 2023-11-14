<?php

namespace App\Http\Controllers;

use App\Contracts\ThreadInterface;
use App\Http\Requests\StoreThreadRequest;
use Inertia\Inertia;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\ThreadResource;

class ForumController extends Controller
{
    public function __construct(
        private ThreadInterface $thread,
    ){}

    public function index()
    {
        return Inertia::render('Forum/Index', [
            'threads' => ThreadResource::collection(
                $this->thread->getFilterablePaginatedCollection()
            ),
        ]);
    }

    public function show(Thread $thread)
    {
        // eager load
        // $thread->load(['user']);

        return Inertia::render('Forum/Show', [
            'thread' => new ThreadResource($thread),
            'posts' => PostResource::collection(
                $this->thread->relatedPosts($thread)
            ),
        ]);
    }

    public function store(StoreThreadRequest $request)
    {
        $thread = $this->thread->store($request->only('title', 'body', 'topic_id'));

        return redirect()->route('forum.show', $thread->slug);
    }


}
