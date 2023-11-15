<?php

namespace App\Http\Controllers;

use App\Contracts\ThreadInterface;
use App\Http\Requests\StoreThreadRequest;
use App\Http\Requests\ThreadStoreRequest;
use App\Http\Requests\ThreadUpdateRequest;
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

    // all
    public function index()
    {
        return Inertia::render('Forum/Index', [
            'threads' => ThreadResource::collection(
                $this->thread->getFilterablePaginatedCollection()
            ),
        ]);
    }

    // show
    public function show(Thread $thread)
    {
        // eager load
        $thread->load(['topic', 'user']);

        return Inertia::render('Forum/Show', [
            'thread' => new ThreadResource($thread),
            'posts' => PostResource::collection(
                $this->thread->relatedPosts($thread)
            ),
        ]);
    }

    // store
    public function store(ThreadStoreRequest $request)
    {
        // store into db
        $thread = $this->thread->store($request->only('title', 'body', 'topic_id'));

        // redirect
        return redirect()->route('forum.show', $thread->slug);
    }

    // update
    public function update(ThreadUpdateRequest $request, Thread $thread)
    {
        // authorize
        $this->authorize('update', $thread);

        // update
        $this->thread->update($thread, [
            'title' => $request->title,
            'body' => $request->body,
            'topic_id' => $request->topic_id,
        ]);

        // redirect
        return redirect()->route('forum.show', $thread);
    }
}
